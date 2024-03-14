<?php

namespace App;

use App\AttributeImage;
use App\Helpers\Tools;
use App\DimensionImage;

class Dimension extends ObjectModel
{

    protected $table = 'dimensions';
    protected $fillable = ["name","attribute","price","product","category","title1","title2","title3","title4","title5","title6","value1","value2","value3","value4","value5","value6"];
    protected $rules = [ ];

    public function __construct()
    {
        $this->AttributeImageObj = new DimensionImage();

    }


    public function getAll()
    {
        return $this->execute('SELECT * FROM dimensions WHERE deleted_at IS NULL ORDER BY attribute DESC ', [] );
    }

    public function getAllOrder()
    {
        return $this->execute('SELECT * FROM dimensions WHERE deleted_at IS NULL', [] );
    }

    public function getById($id)
    {
        return $this->execute('SELECT * FROM dimensions WHERE deleted_at IS NULL AND id = ? ', [$id] );
    }
    public function getByIds($ids)
    {
        $sql = "SELECT * FROM dimensions WHERE";
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
        Tools::updateImages( $id, 'dimension-images', $this->AttributeImageObj );

        return redirect('account.php?page=dimensions', 'The dimension has been added');

    }

    public function update($id, $whereValues = null)
    {

        $uploadedArray = array();



        if( !parent::update('id = :id', ['id' => $id]) ){

            return redirect('account.php?page=dimension&action=edit&id='.$id);

        }

        Tools::updateImages( $id, 'dimension-images', $this->AttributeImageObj );

        return redirect('account.php?page=dimensions', 'The dimensions has been updated');

    }

    public function delete($id)
    {

        $this->updateRow($this->table, ['deleted_at' => DT], 'id = :id  ', [ 'id' => $id ] );

        return redirect('account.php?page=dimensions', 'The dimensions has been deleted');

    }

}
