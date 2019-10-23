<?php

namespace App\Repositories;


class AdminOffersFilter
{
    protected $builder;
	
	const SEARCH_FIELDS = ['search'];
	
	const EXPORTABLE_FIELDS = ['exportable'];
	
	const PUBLISH_TERMS = ['publish_terms'];
    
    const TYPE_FIELDS = ['type'];
    
    const CAT_FIELDS = ['cat'];
    
    const DISTRICT_FIELDS = ['city_district'];
    
    const EMAIL_STATUS_FIELDS = ['status'];
    
    const EMAIL_ID_FIELDS = ['email_id'];
    
    public function __construct($builder,  $request)
    {
        
        $this->builder = $builder;
        $this->request = $request;
        
    }
    
    public function apply()
	{
        $this->addTypeFields();
		$this->addSearchFields();
		$this->addExportableFields();
		$this->addPublishTermsFields();
        $this->addCatFields();
        $this->addDistrictFields();
        $this->addEmailStatusFields();
        $this->addEmailIdFields();

		return $this->builder->orderBy('id', 'desc');
        
        
	}
    
    
    private function addTypeFields()
	{
		$value = $this->getTypeFields();
        
        if(!empty($value[0])){
            
            $this->builder->when($value, function ($query) use ($value) {
            
                $query->where('type', $value);

            });

        }

	}
    
    private function getTypeFields(): array
	{
        
		return array_flatten(array_intersect_key($this->request, array_flip(self::TYPE_FIELDS)));

	}
	
	private function addPublishTermsFields()
	{
		$value = $this->getPublishTermsFields();
        
        if(!empty($value[0])){
            
            $this->builder->when($value, function ($query) use ($value) {
            
                $query->where('publish_terms', $value);

            });

        }

	}
    
    private function getPublishTermsFields(): array
	{
        
		return array_flatten(array_intersect_key($this->request, array_flip(self::PUBLISH_TERMS)));

	}
	
	private function addExportableFields()
	{
		$value = $this->getExportableFields();
        
        if(!empty($value[0])){

			$this->builder->when($value, function ($query) use ($value) {
            
				$query->where($value[0], 1);

			});

        }

	}
    
    private function getExportableFields(): array
	{
        
		return array_flatten(array_intersect_key($this->request, array_flip(self::EXPORTABLE_FIELDS)));

	}
	
	private function addSearchFields()
	{
		$value = $this->getSearchFields();
        
        if(!empty($value[0])){
            
            $this->builder->when($value, function ($query) use ($value) {
            
                $query->where('id', 'LIKE', '%' .  $value[0]  . '%')->orWhere('src_lot', 'LIKE', '%' .  $value[0]  . '%')->orWhere('src_link', 'LIKE', '%' .  $value[0]  . '%');

            });

        }

	}
    
    private function getSearchFields(): array
	{
        
		return array_flatten(array_intersect_key($this->request, array_flip(self::SEARCH_FIELDS)));

	}
    
    private function addCatFields()
	{
		$value = $this->getCatFields();
        
        if(!empty($value[0])){
            $this->builder->when($value, function ($query) use ($value) {

                        return $query->whereHas('cat', function ($query) use ($value) {

                            $query->where('id', $value);

                        });

                    });
        }

	}
    
    private function getCatFields(): array
	{
        
		return array_flatten(array_intersect_key($this->request, array_flip(self::CAT_FIELDS)));

	}
    
    private function addDistrictFields()
	{
		$value = $this->getDistrictFields();
        
        if(!empty($value[0])){
            $this->builder->when($value, function ($query) use ($value) {
                
                        return $query->where('city_district', $value);

                    });
        }

	}
    
    private function getDistrictFields(): array
	{
        
		return array_flatten(array_intersect_key($this->request, array_flip(self::DISTRICT_FIELDS)));

	}
    
    private function addEmailStatusFields()
	{
		$value = $this->getEmailStatusFields();
        
        if(!empty($value[0])){
            $this->builder->when($value, function ($query) use ($value) {
                
                        return $query->where('status', $value);

                    });
        }

	}
    
    private function getEmailStatusFields(): array
	{
        
		return array_flatten(array_intersect_key($this->request, array_flip(self::EMAIL_STATUS_FIELDS)));

	}
    
    private function addEmailIdFields()
	{
		$value = $this->getEmailIdFields();
        
        if(!empty($value[0])){
            $this->builder->when($value, function ($query) use ($value) {
                
                        $id = auth()->user()->unreadNotifications[0]->id;
                
                        auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
                
                        return $query->where('id', $value);

                    });
        }

	}
    
    private function getEmailIdFields(): array
	{
        
		return array_flatten(array_intersect_key($this->request, array_flip(self::EMAIL_ID_FIELDS)));

	}
    

    
}
