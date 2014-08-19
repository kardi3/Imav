<?php

/**
 * Slider_DataTables_Slide
 *
 * @author Tomasz Kardas <kardi31@o2.pl>
 */
class Slider_DataTables_Slide extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Slider_DataTables_Adapter_Slide';
    }
}

