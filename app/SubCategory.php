<?php	

namespace App;

class SubCategory extends ObjectModel
{

    protected $table = 'sub_categories';
    protected $fillable = ['title', 'seo_url', 'category_id'];
    protected $rules = ['title' => 'required', 'seo_url' => 'required', 'category_id' => 'required'];

    public function getAll()
    {

	return $this->execute('SELECT *, sub_categories.title AS sub_category_title, sub_categories.seo_url AS sub_category_seo_url, sub_categories.id AS sub_category_id  
					FROM sub_categories LEFT JOIN categories ON categories.id = sub_categories.category_id 
					WHERE sub_categories.deleted_at IS NULL ORDER BY category_id ASC ', []);
	
    }
    
    
    public function getAllByCategoryId($category_id)
    {

	return $this->execute('SELECT * FROM sub_categories WHERE sub_categories.category_id = ? AND sub_categories.deleted_at IS NULL ', [ $category_id ]);
	
    }
    
    public function getSubCategoryByCategoryIdAndSlug($category_id, $slug)
    {

	return $this->execute('SELECT * FROM sub_categories WHERE sub_categories.category_id = ? AND sub_categories.seo_url = ? AND sub_categories.deleted_at IS NULL ', [ $category_id, $slug ]);
	
    }


    public function add()
    {

	if (!$this->validate()) {

		return redirect('account.php?page=sub-category&action=add');

	}

	parent::add();

	return redirect('account.php?page=sub-categories', 'The sub category has been added');

    }


    public function delete($id)
    {

	$this->updateRow($this->table, ['deleted_at' => DT], 'id = :id  ', ['id' => $id]);

	return redirect('account.php?page=sub-categories', 'The sub category has been deleted');

    }


    public function update($id, $whereValues = null)
    {

	if (!parent::update('id = :id', ['id' => $id])) {

		return redirect('account.php?page=sub-category&action=edit&id=' . $id);

	}

	return redirect('account.php?page=sub-categories', 'The sub category has been updated');

    }

}
