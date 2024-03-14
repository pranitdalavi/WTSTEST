<?php	

namespace App;

use App\Helpers\Tools;
use App\ProductImage;

class Product extends ObjectModel{

    protected $table = 'products';
    protected $fillable = ['seo_block','connected_dimensions','long_description','title','connected', 'seo_url', 'category_id', 'sub_category_id','brand', 'price', 'special_offer_price', 'description', 'attributes', 'best_seller', 'product_code', 'weight', 'sku', 'sale_item', 'width', 'height', 'depth', 'capacity', 'dimensions_extra', 'dimensions_extra_2', 'product_status', 'deal_day', 'deal_week', 'delivery_options','qty_available'];
    protected $rules = [
					'title' => 'required',
					'seo_url' => 'required|unique:products',
					'price' => 'required'
			];
			
			
    public function __construct()
    {
    
	$this->productImageObj = new ProductImage;
    
    }


    public function getAll()
    {

	$query = $this->execute('SELECT *, products.title AS product_title, products.id AS product_id, categories.title AS category_title, products.seo_url AS product_seo_url, products.sku AS product_sku,
					products.id AS product_id FROM products 
					LEFT JOIN categories ON categories.id = products.category_id 
					WHERE products.deleted_at IS NULL ORDER BY products.category_id ASC  ', [] );
					
	foreach($query as $row){
	
	//	$this->updateRow($this->table, ['category_id' => '["'.$row->category_id.'"]', 'sub_category_id' => '["'.$row->sub_category_id.'"]'], 'id = :id  ', [ 'id' => $row->product_id ] );
	
	}

	return $query;

    }


    public function getAllByCustomer()
    {

        $query = $this->execute('SELECT * FROM products WHERE deleted_at IS NULL', [] );

        return $query;

    }
    public function getAllBrands($category_id)
    {

        $query = $this->execute('SELECT brand FROM products WHERE deleted_at IS NULL AND brand != "" AND category_id LIKE ? GROUP BY brand', ["%". $category_id ."%"] );

        return $query;

    }
    public function getProductCategories($product_id)
    {

        $query = $this->execute('SELECT category_id FROM products WHERE deleted_at IS NULL AND id LIKE ? ORDER BY price ASC', [$product_id] )[0]->category_id;

        return $query;

    }
    public function getAllBrandsAllCategories()
    {

        $query = $this->execute('SELECT brand FROM products WHERE deleted_at IS NULL AND brand != "" GROUP BY brand', [] );

        return $query;

    }
    public function getMinPrice($category_id)
    {

        $query = $this->execute('SELECT price,special_offer_price FROM products WHERE deleted_at IS NULL AND category_id LIKE ?', ["%". $category_id ."%"] );
        foreach ($query as $item){
            if($item->special_offer_price != "" and $item->special_offer_price != null){
                $item->price = $item->special_offer_price;
            }
        }
        $price = array_column($query, 'price');

        array_multisort($price, SORT_ASC, $query);

        return [$price[0],end($price)];

    }
    public function getMinPriceAllCategories()
    {

        $query = $this->execute('SELECT price,special_offer_price FROM products WHERE deleted_at IS NULL ', [] );
        foreach ($query as $item){
            if($item->special_offer_price != "" and $item->special_offer_price != null){
                $item->price = $item->special_offer_price;
            }
        }
        $price = array_column($query, 'price');

        array_multisort($price, SORT_ASC, $query);

        return [$price[0],end($price)];

    }
    public function getAllSearchAdmin($search)
    {

	return $this->execute('SELECT *, products.title AS product_title, categories.title AS category_title, products.seo_url AS product_seo_url, 
					products.id AS product_id FROM products 
					LEFT JOIN categories ON categories.id = products.category_id 
					WHERE products.deleted_at IS NULL AND ( products.title LIKE ? OR products.product_code LIKE ? OR products.sku LIKE ? )  ', ["%".$search."%", "%".$search."%", "%".$search."%"] );

    }
    
    
    public function getAllCrossell()
    {

	return $this->execute('SELECT *, products.title AS product_title, 
					products.title AS product_title, categories.title AS category_title,
					products.seo_url AS product_seo_url, products.id AS product_id FROM products 
					LEFT JOIN categories ON categories.id = products.category_id 
					WHERE products.deleted_at IS NULL AND products.qty_available > 0 ORDER BY products.price ASC', [] );

    }
    
    
    public function updateCrossSells($id)
    {
    
	$json = '';
    
	if(isset($_POST['ids'])){

		$json = json_encode($_POST['ids']);
	
	}

	$this->updateRow($this->table, ['cross_sell_ids' => $json], 'id = :id  ', [ 'id' => $id ] );
	return redirect( 'account?page=cross-sell&id='.$id, 'Your cross sell products have been updated' );	

    }
    

    public function getAllForHomepage()
    {

	return $this->execute('SELECT * FROM products WHERE deleted_at IS NULL AND best_seller = 1 ORDER BY RAND() LIMIT 4 ', [] );

    }



    
    public function getMattresses($category)
    {

	return $this->execute('SELECT * FROM products WHERE deleted_at IS NULL AND service = 0 and category_id LIKE ? ORDER BY price ASC', ["%".$category."%"] );

    }


    public function getMattressesNew($category)
    {

	return $this->execute('SELECT * FROM products WHERE deleted_at IS NULL AND service = 0 and category_id LIKE ? AND ID != ? ORDER BY price ASC', ["%".$category."%", "87"] );

    }

    public function getById($id)
    {

	return $this->execute('SELECT * FROM products WHERE deleted_at IS NULL AND id = ?  ORDER BY price ASC', [$id] );

    }
    

    public function getAllByCategory($category_id)
    {
        $maxPrice = 99999999;
        if(isset($_GET["max_price"])){
            $maxPrice = $_GET["max_price"];
        }
        $options = [];
        $brands = $this->getAllBrands($category_id);
        $bX = 0;
        foreach ($brands as $brand) {
            $bX++;
            if(isset($_GET["brand". $bX])){
                array_push($options,$_GET["brand". $bX]);
            }
        }


        if(count($options) > 0){
            $searchTermBits = array();
            foreach ($options as $term) {
                $term = trim($term);

                if (!empty($term)) {
                    $searchTermBits[] = " brand LIKE '%$term%' OR category_id LIKE '%". $category_id."%' AND deleted_at IS NULL AND brand LIKE '%$term%' AND price <= '".$maxPrice ."' AND ";
                }
            }

            $result = "SELECT * FROM products WHERE category_id LIKE '%". $category_id ."%' AND deleted_at IS NULL AND ".implode('', $searchTermBits);
            $result = substr($result,0,-5);



        }
        else{
            $result = "SELECT * FROM products WHERE category_id LIKE '%". $category_id ."%' AND deleted_at IS NULL AND price <= '".$maxPrice ."' ORDER BY price ASC";
        }
      
	    return $this->execute($result, [] );

    }
    
    public function getAllBySubCategory($sub_categoryId, $category_id)
    {

	return $this->execute("SELECT * FROM products WHERE 
					sub_category_id LIKE ? AND category_id LIKE ? AND products.deleted_at IS NULL  
					ORDER BY products.id DESC ", ["%\"".$sub_categoryId."\"%", "%\"".$category_id."\"%"] );		

    }
    
    public function getLatest()
    {

	return $this->execute("SELECT * FROM products WHERE 
					products.deleted_at IS NULL ORDER BY products.id DESC LIMIT 4 ", [] );		

    }
    
    
    public function bestSellers()
    {

	return $this->execute("SELECT * FROM products WHERE 
					products.deleted_at IS NULL AND best_seller = 1 LIMIT 8 ", [] );

    }
    
    
    public function sale()
    {

	return $this->execute("SELECT * FROM products WHERE 
					products.deleted_at IS NULL AND sale_item = 1 ", [] );		

    }
    
    public function dealWeek()
    {

	return $this->execute("SELECT * FROM products WHERE 
					products.deleted_at IS NULL AND deal_week = 1 ", [] );		

    }
    
    
    public function dealDay()
    {

	return $this->execute("SELECT * FROM products WHERE 
					products.deleted_at IS NULL AND deal_day = 1 ", [] );		

    }
    public function relatedProducts($currentid,$category_ids)
    {
        $options = $category_ids;
        $searchTermBits = array();
        foreach ($options as $term) {
            $term = trim($term);

            if (!empty($term)) {
                $searchTermBits[] = "category_id LIKE '%$term%' AND deleted_at IS NULL AND id != '". $currentid ."' OR ";
            }
        }

        $result = "SELECT * FROM products WHERE ".implode('', $searchTermBits);


        $result = substr($result,0,-4);
        $result .= " LIMIT 4";


	return $this->execute($result, [] );

    }
		
		
    public function search($search)

    {


        $search = "";
        if(isset($_GET["q"])){
            $search = $_GET["q"];
        }



        $result = "SELECT * FROM products WHERE deleted_at IS NULL AND title LIKE '%".$search ."%' AND service = 0";

        return $this->execute($result, [] );

    }



    public function getProductById($id)
    {

	return $this->execute("SELECT *, products.id AS product_id, products.title AS product_title 
					FROM products LEFT JOIN sub_categories ON sub_categories.id = products.sub_category_id 
					WHERE products.id = ?  ", [$id] );		

    }
    
    
    public function getAttributes()
    {
    
	if( !count($_POST['attributes']) ){
	
		return '';
	
	}

	$attributes = json_encode($_POST['attributes']);
	
	return $attributes;

    }
    


    public function add()
    {
	Tools::validateImages();

    	$this->seo_url = preg_replace("/[^A-Za-z0-9-]/", '', strtolower($_POST['seo_url']));

	if( !$this->validate() ){
	
		return redirect('account.php?page=product&action=add');
	
	}

	/*$this->attributes = $this->getAttributes();*/

        $this->category_id = json_encode($_POST['categories']);


        if(isset($this->connected)){
            $this->connected = json_encode($_POST['connected']);
        }



	
	$id = parent::add();
	
	Tools::addImages( $id, 'product-images', $this->productImageObj );

	return redirect('account.php?page=products', 'The product has been added');

    }
		
		
    public function update($id, $whereValues = null)
    {


	$uploadedArray = array();
	
	/*  See if file uploads are valid images  */
    
	Tools::validateImages();
	
	/*  Remove all but chars and dashes from seo url  */

	$this->seo_url = preg_replace("/[^A-Za-z0-9-]/", '', strtolower($_POST['seo_url']));

	
	$this->category_id = json_encode($_POST['categories']);

        $this->connected = json_encode($_POST['connected']);


	if( !parent::update('id = :id', ['id' => $id]) ){
	
		return redirect('account.php?page=product&action=edit&id='.$id);
	
	}


	Tools::updateImages( $id, 'product-images', $this->productImageObj );

	return redirect('account.php?page=products', 'The product has been updated');

    }


    public function delete($id)
    {

	$this->updateRow($this->table, ['deleted_at' => DT], 'id = :id  ', [ 'id' => $id ] );
	
	return redirect('account.php?page=products', 'The product has been deleted');

    }


    public function deleteImage($image)
    {

	copy('../product-images/'.$image, '../deleted-product-images/'.$image);
	unlink('../product-images/'.$image);

	return redirect( 'account.php?page=product&action=edit&id='.$_GET['id'], 'The image has been deleted' );

    }
		
		
    public function uploadImages($id)
    {

	foreach($_FILES as $key => $file){
	
		$fileNum = str_replace('file-', '', $key);

		if($_FILES[$key]['size'] > 0){

			$explodedot = explode('.', $_FILES[$key]['name']);
			$ext = $explodedot[sizeof($explodedot)-1];
			$ext = strtolower($ext);

			$size = getimagesize($_FILES[$key]['tmp_name']);

				if(empty($size)){
				
					return redirect( 'account.php?page=product&action=edit&id='.$id, 'You must upload a valid image', 'e' );
				
				}

				if ( $ext != "jpg" && $ext != "png" && $ext != "gif" ){
				
					return redirect( 'account.php?page=product&action=edit&id='.$id, 'JPG, PNG or GIF extensions only', 'e' );
				
				}
			
				if(file_exists('../product-images/'.$id.'-'.$fileNum.'.jpg')){ 
				
					unlink( '../product-images/'.$id.'-'.$fileNum.'.jpg' );
					
				}
				
				if(file_exists('../product-images/'.$id.'-'.$fileNum.'.png')){
				
					unlink( '../product-images/'.$id.'-'.$fileNum.'.png' );
				
				}
				
				if(file_exists('../product-images/'.$id.'-'.$fileNum.'.gif')){
				
					unlink( '../product-images/'.$id.'-'.$fileNum.'.gif' );
				
				}
				
				if(file_exists('../product-images/'.$id.'-'.$fileNum.'.jpeg')){
				
					unlink( '../product-images/'.$id.'-'.$fileNum.'.jpeg' );
				
				}
			
				move_uploaded_file($_FILES[$key]['tmp_name'], '../product-images/'.$id.'-'.$fileNum.'.'.$ext);

		}

	}

    }
		
		
    public function updateTable()
    {

	$query = $this->execute('SELECT * FROM products WHERE products.deleted_at IS NULL ', [] );
	
	foreach($query as $row){
	
		$count = substr_count($row->size, 'X');
		
		if($count == 2){
		
			$explode = explode('X', $row->size);
			
			$this->updateRow($this->table, ['inner_diameter' => trim($explode[0]), 'outer_diameter' => trim($explode[1]), 'thickness' => trim($explode[2])], 'id = :id LIMIT 1 ', [ 'id' => $row->id ] );
		
		}
	
		
	
	}

    }



}
