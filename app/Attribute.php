<?php

namespace App;

use App\Helpers\Tools;
use App\AttributeImage;

class Attribute extends ObjectModel
{

    protected $table = 'attributes';
    protected $fillable = ["material_group","name","attribute","price","category","order_num","storage_limit","show_mattress","trigger_mattress"];
    protected $rules = [ ];

    public function __construct()
    {
        $this->AttributeImageObj = new AttributeImage();

    }


    public function getAll()
    {
        return $this->execute('SELECT * FROM attributes WHERE deleted_at IS NULL ORDER BY attribute DESC ', [] );
    }


    public function getAllSmallImages()
    {
        return $this->execute('SELECT * FROM attributes WHERE deleted_at IS NULL ORDER BY rand() LIMIT 10 ', [] );
    }


    public function getCategories()
    {
        return $this->execute('SELECT category FROM attributes WHERE deleted_at IS NULL GROUP BY category', [] );
    }
    public function getMaterialGroups()
    {
        return $this->execute('SELECT material_group FROM attributes WHERE deleted_at IS NULL AND material_group IS NOT NULL GROUP BY material_group', [] );
    }

    public function getAllSearch($cat)
    {
        if($cat == "all"){
            $cat = "";
        }
        return $this->execute('SELECT * FROM attributes WHERE deleted_at IS NULL AND category LIKE ? ORDER BY order_num ASC ', ["%".$cat."%"] );
    }

  public function getAllOrder()
    {
        return $this->execute('SELECT * FROM attributes WHERE deleted_at IS NULL ORDER BY order_num ASC ', [] );
    }

    public function getById($id)
    {
        return $this->execute('SELECT * FROM attributes WHERE deleted_at IS NULL AND id = ? ', [$id] );
    }
    public function getByIds($ids)
    {
        $sql = "SELECT * FROM attributes WHERE";
        foreach ($ids as $id){
            $sql .= " deleted_at IS NULL AND id = ". $id ." OR";
        }
        $sql = substr($sql, 0, -3);
        $sql .= " GROUP BY attribute";

        return $this->execute($sql, [] );
    }

    public function add()
    {



        $id = parent::add();
        Tools::updateImages( $id, 'attribute-images', $this->AttributeImageObj );

        return redirect('account.php?page=attributes&category='. $_GET["category"], 'The attribute has been added');

    }

    public function update($id, $whereValues = null)
    {

        $uploadedArray = array();



        if( !parent::update('id = :id', ['id' => $id]) ){

            return redirect('account.php?page=attribute&action=edit&id='.$id);

        }

        Tools::updateImages( $id, 'attribute-images', $this->AttributeImageObj );

        return redirect('account.php?page=attributes&category='. $_GET["category"], 'The attribute has been updated');

    }

    public function delete($id)
    {

        $this->updateRow($this->table, ['deleted_at' => DT], 'id = :id  ', [ 'id' => $id ] );

        return redirect('account.php?page=attributes&category='. $_GET["category"], 'The attribute has been deleted');

    }

}
