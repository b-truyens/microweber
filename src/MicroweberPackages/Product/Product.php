<?php
namespace MicroweberPackages\Product;

use Illuminate\Database\Eloquent\Model;
use MicroweberPackages\Content\Scopes\ProductScope;
use MicroweberPackages\ContentData\ContentData;
use MicroweberPackages\Content\Content;
use MicroweberPackages\CustomField\CustomField;

class Product extends Content
{
    protected $table = 'content';

    protected $content_type = 'product';

    public function getMorphClass()
    {
        return 'content';
    }


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new ProductScope());
    }

    public function data()
    {
        return $this->morphMany(ContentData::class, 'rel');
    }

    public function customField()
    {
        return $this->hasMany(CustomField::class, 'rel_id');
    }

    private function fetchSingleAttributeByName ($name)
    {
        foreach($this->customField as $customFieldRow) {
            if($customFieldRow->type == $name) {
                if(isset($customFieldRow->fieldValue[0]->value)) { //the value field must be only one
                    return $customFieldRow->fieldValue[0]->value;
                }
            }
        }

        return null;
    }

    private function fetchSingleContentDataByName($name)
    {
        foreach($this->data as $contentDataRow) {
            if($contentDataRow->field_name == $name) {
                return $contentDataRow->field_value;
            }
        }

        return null;
    }

    public function getPriceAttribute()
    {
        return $this->fetchSingleAttributeByName('price');
    }

    public function getQtyAttribute()
    {
        return $this->fetchSingleContentDataByName('qty');
    }

    public function scopeWhereContentData($query, $whereArr)
    {
        $query->whereHas('data', function($query) use ($whereArr){
            foreach($whereArr as $fieldName => $fieldValue) {
                $query->where('field_name', $fieldName)->where('field_value', $fieldValue);
            }
        });

        return $query;
    }
}
