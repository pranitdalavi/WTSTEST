<?php

namespace App;

use App\Helpers\Tools;
use App\BlogImage;

class Blog extends ObjectModel
{

    protected $table = 'blogs';
    protected $fillable = ['title', 'seo_url', 'content'];
    protected $rules = [ 'title' => 'required', 'seo_url' => 'required|unique:blogs', 'content' => 'required' ];
    
    public function __construct()
    {
    
	$this->blogImageObj = new BlogImage;
    
    }

	
    public function getAll()
    {
	return $this->execute('SELECT * FROM blogs WHERE deleted_at IS NULL ORDER BY created_at DESC ', [] );
    }


    public function add()
    {
    
	Tools::validateImages();
    
	$this->seo_url = preg_replace("/[^A-Za-z0-9-]/", '', strtolower($_POST['seo_url']));
		
	if( !$this->validate() ){
	
		return redirect('account.php?page=blog&action=add');
	
	}
	
	$id = parent::add();
	
	Tools::addImages( $id, 'blog-images', $this->blogImageObj );

	return redirect('account.php?page=blogs', 'The blog has been added');
		
    }

    
    public function update($id, $whereValues = null)
    {
    
	$uploadedArray = array();
	
	/*  See if file uploads are valid images  */
    
	Tools::validateImages();
	
	/*  Remove all but chars and dashes from seo url  */
    
	$this->seo_url = preg_replace("/[^A-Za-z0-9-]/", '', strtolower($_POST['seo_url']));
		
	if( !parent::update('id = :id', ['id' => $id]) ){
	
		return redirect('account.php?page=blog&action=edit&id='.$id);
	
	}
	
	Tools::updateImages( $id, 'blog-images', $this->blogImageObj );
	
	return redirect('account.php?page=blogs', 'The blog has been updated');

    }


    public function delete($id)
    {
		
	$this->updateRow($this->table, ['deleted_at' => DT], 'id = :id  ', [ 'id' => $id ] );
	
	return redirect('account.php?page=blogs', 'The blog has been deleted');

    }


}
