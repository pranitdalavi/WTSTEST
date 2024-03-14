<?php

namespace App;

class BlogImage extends ObjectModel
{

    protected $table = 'blog_images';
    protected $fillable = ['blog_id', 'alt', 'ext'];
    protected $rules = [];

    public function getAll($blog_id = null)
    {
	$blog_id = $blog_id ? $blog_id : $_GET['id'];
	return $this->execute('SELECT * FROM blog_images WHERE blog_id = ? AND deleted_at IS NULL ORDER BY id ASC ', [ $blog_id ] );
    }


    public function addImage($blog_id, $alt, $ext)
    {
    
	$this->blog_id = $blog_id;
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
