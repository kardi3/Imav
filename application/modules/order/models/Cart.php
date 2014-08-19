<?php

/**
 * Order_Model_Cart
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Order_Model_Cart {
    
    protected $session;
    protected $prices;
    protected $values;


    public function __construct() {
        $this->session = new Zend_Session_Namespace('CART');
        $this->prices = new Zend_Session_Namespace('prices');
        $this->values = new Zend_Session_Namespace('values');
    }
    
    public function getItems($class = null) {
        if(!$items = $this->session->items) {
            $items = array();
            $this->session->items = $items;
        }
        if(null != $class) {
            if(isset($items[$class])) {
                return $items[$class];
            }
        }
        return $items;
    }
    public function getPrices($class = null) {
        if(!$prices = $this->session->prices) {
            $prices = array();
            $this->session->prices = $prices;
        }
        if(null != $class) {
            if(isset($prices[$class])) {
                return $prices[$class];
            }
        }
        return $prices;
    }
    public function getPrice($field) {
        if(!$prices = $this->session->prices) {
            $prices = array();
            $this->session->prices = $prices;
        }
        if(null != $class) {
            if(isset($prices[$class])) {
                return $prices[$class];
            }
        }
        return $prices[$field];
    }
    public function get($class, $id = null, $index = null) {
        $items = $this->getItems();
        if(isset($items[$class])) {
            if(null !== $id && isset($items[$class][$id])) {
                if(null !== $index && isset($items[$class][$id][$index])) {
                    return $items[$class][$id][$index];
                }
                return $items[$class][$id];
            }
            return $items[$class];
        }
    }
    
    public function add($class, $id, $name, $price, $count, $index, $absolutePrice = false, $options = array()) {
        
        $productService = new Product_Service_Product();
        
        $items = $this->getItems();
        if(!isset($items[$class])) {
            $items[$class] = array();
        }
        if(!isset($items[$class][$id])) {
            $items[$class][$id] = array();
        }
        // pobieramy cene podanego rozmiaru
        $dim = $productService->getProduct($id);
        if($dim['promotion']==1)
            $price = number_format($dim['promotion_price'] * $count,2);
        else
            $price = number_format($dim['price'] * $count,2);
        $items[$class][$id][$index] = array('name' => $name, 'price' => $price, 'count' => $count, 'index' => $index, 'absolute' => $absolutePrice, 'options' => $options);
      Zend_Debug::dump($items);
        echo "dodnio";
        $this->session->items = $items;
    }
    
    public function remove($class, $id = null, $index = null) {
        $items = $this->getItems();
        if(isset($items[$class])) {
            if(null != $id) {
                if(null != $index) {
                    unset($items[$class][$id][$index]);
                } else {
                    unset($items[$class][$id]);
                }
            } else {
                unset($items[$class]);
            }
        }
        $this->session->items = $items;
    }
      public function updateNumber($product_id,$number) {
        $items = $this->getItems();
        $items['Product_Model_Doctrine_Product'][$product_id]['']['count'] = $number; 
        $this->session->items = $items;
    }
    public function storeValues($values)
    {
        $this->values->values = $values;
    }
    public function getValues()
    {
        return $this->values->values;
    }
    public function count($class = null, $id = null, $index = null) {
        $items = $this->getItems();

        $result = 0;
        
        if(null == $class) {
            foreach($items as $class => $ids) {
                foreach($ids as $id => $indexes) {
                    foreach($indexes as $index => $data) {
                        if(isset($data['count'])) {
                            $result += (int) $data['count'];
                        }
                    }
                }
            }
        } else {
            if(isset($items[$class])) {
                if(null == $id) {
                    if(null != $index) {
                        foreach($items[$class][$id] as $indexes) {
                            foreach($indexes as $index => $data) {
                                $result += (int) $data['count'];
                            }
                        }
                    } else {
                        foreach($items[$class] as $ids) {
                            foreach($ids as $id => $indexes) {
                                foreach($indexes as $index => $data) {
                                    $result += (int) $data['count'];
                                }
                            }
                        }
                    }
                } else {
                    if(isset($items[$class][$id])) {
                        $result += $items[$class][$id]['count'];
                    }
                }
            }
        }
        return $result;
    }
    
    public function getSum() {
        $items = $this->getItems();
        
        $result = 0;

        foreach($items as $class => $ids) {
            foreach($ids as $id => $indexes) {
                foreach($indexes as $index => $data) {
                    if(isset($data['price'])) {
                        if(isset($data['count']) && !$data['absolute']) {
                            $result += $data['count'] * $data['price'];
                        } else {
                            $result += $data['price'];
                        }
                    }
                }
            }
        }
        
        return $result;
    }
    
    public function clean() {
        $this->session->items = array();
        $this->session->prices = array();
    }
    public function cleanPrices() {
        $this->session->prices = array();
    }
    public function updatePrice($field,$value)
    {
        $prices = $this->getPrices();
        $prices[$field] = $value; 
        $this->session->prices = $prices;
    }
    public function countItemsValue()
    {
        $values = $this->getItems();
     foreach($values['Product_Model_Doctrine_Product'] as $item):
       foreach($item as $itemDetail):
            $sumPrice += $itemDetail['price']*$itemDetail['count'];
        endforeach;
    endforeach;
    return number_format($sumPrice,2);
    }
     public function countDiscountedPrice($itemsValue,$discountValue)
    {
         $discountValue /= 100;
        $newPrice = $itemsValue*(1-$discountValue);
        return $newPrice;
    }
}

