<?php

/**
 * AdapterAbstract
 *
 * @author Tomasz Kardas <kardi31@o2.pl>
 */
abstract class Default_DataTables_Adapter_AdapterAbstract implements Default_DataTables_Adapter_AdapterInterface {
    
    protected $request;
    protected $table;
    protected $columns = array();
    protected $searchFields = array();
    protected $query;
    protected $data;
    
    public function __construct(Zend_Controller_Request_Abstract $request, Doctrine_Table $table) {
        $this->request = $request;
        $this->table = $table;
    }
    
    public function getTable() {
        return $this->table;
    }
    
    public function getQuery() {
        if(null == $this->query) {
            $q = $this->getBaseQuery();
            if($this->request->getParam('iDisplayLength')) {
                $q->limit($this->request->getParam('iDisplayLength'));
            }
            if($this->request->getParam('iDisplayStart')) {
                $q->offset($this->request->getParam('iDisplayStart'));
            }
            if(strlen($this->request->getParam('iSortCol_0'))) {
                $q = $this->returnSortQuery($q);
            }
            if($this->request->getParam('sSearch')) {
                $q = $this->returnSearchQuery($q);
            }
            
            $q = $this->returnSearchAdvQuery($q);
            $this->query = $q;
        }
        return $this->query->copy();
    }
    
    protected function getBaseQuery() {
        return $this->table->createQuery('x');
    }
    
    public function getData() {
        if(null == $this->data) {
            $this->data = $this->getQuery()->execute();
        }
        return $this->data;
    }
    
    public function setColumns(array $columns) {
        $this->columns = $columns;
    }
    
    public function getColumns() {
        return $this->columns;
    }
    
    public function setSearchFields(array $searchFields) {
        $this->searchFields = $searchFields;
    }
    
    public function getSearchFields() {
        return $this->searchFields;
    }
    
    protected function returnSortQuery(Doctrine_Query $q) {
        $columns = $this->getColumns();
        for($i=0; $i < intval($this->request->getParam('iSortingCols')); $i++) {
            if($this->request->getParam('bSortable_'.intval($this->request->getParam('iSortCol_'.$i))) == "true") {
                if(isset($columns[intval($this->request->getParam('iSortCol_'.$i))])) {
                    $order = $columns[intval($this->request->getParam('iSortCol_'.$i))];
                    $dir = $this->request->getParam('sSortDir_'.$i);
                    $q->addOrderBy("$order $dir");
                }
            }
        }

        return $q;
    }
    
    protected function returnSearchQuery(Doctrine_Query $q) {
        $phrase = $this->request->getParam('sSearch');
        $queryString = '';
        $queryParts = array();
        foreach($this->getSearchFields() as $field) {
            $queryParts[] = "$field LIKE ?";
            $queryString .= "$field LIKE ? "; 
        }
        $q->andWhere(implode(' OR ', $queryParts), array_fill(0, count($this->getSearchFields()), "%$phrase%"));
        return $q;
    }
    
    // wykonany dla yadcf column filter
    protected function returnSearchAdvQuery(Doctrine_Query $q) {
        
        
        $fields = $this->getSearchFields();
        $counter = count($fields);
        if($counter>0){
            for($i=0;$i<$counter;$i++):
                if($this->request->getParam("sSearch_$i")){
                    $phrase = $this->request->getParam("sSearch_$i");
                    // sprawdzamy czy to jest filtr data_range
                    if((strpos($phrase,'yadcf_delim') > 1) || (substr_count($phrase,'-') == 2))
                    {
                       $elements = explode('-',$phrase);
                        // ssearch dla data range ma postac
                        // 1402783200000-yadcf_delim-1406498400000
                        // pobierane są milisekundy i konwertowane na odpowiednią date
                       if(!empty($elements[0])){
                            $mil = $elements[0];
                            $sec = $mil/1000;
                            $q->andWhere("$fields[$i] >= ?",date("Y-m-d", $sec));
                       }
                       
                       if(!empty($elements[2])){
                           $mil2 = $elements[2];
                            $sec2 = $mil2/1000;
                            // dodajemy 1 dzien do daty do poniewaz gdy wybierzemy np. 28 lipca to filtr zwróci nam wszystkie wartości 
                            //  mające date mniejszą od 28 lipca 00:00
                            $date1 = date("m/d/Y", $sec2);
                            $tommorow = date('Y-m-d',strtotime($date1 . "+1 days"));
                            
                            $q->andWhere("$fields[$i] <= ?",$tommorow);
                       }
                    }
                    elseif($phrase!="-yadcf_delim-"){
                        if($phrase=="empty_value"):
                            $phrase = 0;
                        endif;
                         if($phrase=="brak"&&!is_int($phrase)):
                            $q->andWhere("$fields[$i] is NULL");
                         else:
                            $q->andWhere("$fields[$i] like '%$phrase%'");
                         endif;
                    }
                    
                }
            endfor;
        }
        return $q;
    }
}

