<?php

namespace App;

class ProductImage extends ObjectModel
{

    protected $table = 'product_images';
    protected $fillable = ['product_id', 'alt', 'ext'];
    protected $rules = [];

    public function getAll($product_id = null)
    {
	$product_id = $product_id ? $product_id : $_GET['id'];
	return $this->execute('SELECT * FROM product_images WHERE product_id = ? AND deleted_at IS NULL ORDER BY id ASC ', [ $product_id ] );
    }


    public function addImage($product_id, $alt, $ext)
    {

	$this->product_id = $product_id;
	$this->alt = $alt;
	$this->ext = $ext;
    
	return parent::add();

    }


    public function delete($id)
    {
		
	$this->updateRow($this->table, ['deleted_at' => DT], 'id = :id  ', [ 'id' => $id ] );
	return redirect( $_SERVER['HTTP_REFERER'] , 'The image has been deleted' );

    }

    
    public function updateImage($id, $alt, $ext)
    {

	$this->alt = $alt;
	$this->ext = $ext;

	parent::update('id = :id', ['id' => $id]);
	
    }


}
