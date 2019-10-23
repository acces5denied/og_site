<?php

namespace App\Repositories;

class NewsFilter
{
    protected $builder;
    
	const ORDER_FIELDS = ['sort', 'sort_type'];  
    
    public function __construct($builder,  $request)
    {
        
        $this->builder = $builder;
        $this->request = $request;
        
    }
    
    public function apply()
	{
		$this->addOrderFields();

		return $this->builder;

	}
    
    //сортировка
    private function addOrderFields()
	{
		$value = $this->getOrderFields();
        
        $sortItems = [
            'created_at',
            'id'
        ];

		if (isset($value[self::ORDER_FIELDS[0]]) && in_array($value[self::ORDER_FIELDS[0]], $sortItems)) {
            
           $this->builder->orderBy(
                $value[self::ORDER_FIELDS[0]],
                $value[self::ORDER_FIELDS[1]] ?? 'asc'
            );

        } 
        
	}
    private function getOrderFields(): array
	{
		return array_intersect_key($this->request, array_flip(self::ORDER_FIELDS));
	}
    //** END **//
    
}
