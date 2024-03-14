<?php

namespace App;

class Category extends ObjectModel
{

    protected $table = 'categories';
    protected $fillable = ['title', 'seo_url', 'sort_order','info','seo_block'];
    protected $rules = ['title' => 'required', 'seo_url' => 'required|unique:categories', 'sort_order' => 'required',];

	
    public function getAll()
    {
	return $this->execute('SELECT * FROM categories WHERE deleted_at IS NULL ORDER BY sort_order ASC ', [] );
    }
    public function getData($seo)
    {
	return $this->execute('SELECT * FROM categories WHERE deleted_at IS NULL and seo_url = ? ', [$seo] );
    }
    public function getDataById($id)
    {
        return $this->execute('SELECT * FROM categories WHERE deleted_at IS NULL and id = ? ', [$id] );
    }


    public function add()
    {


	$this->seo_url = preg_replace("/[^A-Za-z0-9-]/", '', strtolower($_POST['seo_url']));




	if( !$this->validate() ){
	
		return redirect('account.php?page=category&action=add');
	
	}
	
	$id = parent::add();


        $path=$_FILES['image']['name'];
        $path_parts = pathinfo($_FILES["image"]["name"]);
        $extension = $path_parts['extension'];
        $pathto= str_replace("\app","",__DIR__)."/category-images/".$id. ".jpg";
        move_uploaded_file( $_FILES['image']['tmp_name'],$pathto);



	return redirect('account.php?page=categories', 'The category has been added');
		
    }
		
		
    public function delete($id)
    {
		
	$this->updateRow($this->table, ['deleted_at' => DT], 'id = :id  ', [ 'id' => $id ] );
	
	return redirect('account.php?page=categories', 'The category has been deleted');
		
    }
		
    
    public function update($id, $whereValues = null)
    {
    
	$this->seo_url = preg_replace("/[^A-Za-z0-9-]/", '', strtolower($_POST['seo_url']));

        $path=$_FILES['image']['name'];
        $path_parts = pathinfo($_FILES["image"]["name"]);
        $extension = $path_parts['extension'];

        $pathto= str_replace("/app","",__DIR__)."/category-images/".$id. ".jpg";

        move_uploaded_file( $_FILES['image']['tmp_name'],$pathto);
	if( !parent::update('id = :id', ['id' => $id]) ){
	
		return redirect('account.php?page=category&action=edit&id='.$id);
	
	}

	return redirect('account.php?page=categories', 'The category has been updated');

    }



}
