<?php
namespace App;
class Page extends ObjectModel{

    protected $table = 'pages';
    protected $fillable = [ 'name','position', 'description', 'link1', 'link2', 'link3',  'link1_name', 'link2_name', 'link3_name', 'img_title', 'extension'];
    protected $rules = [];


    public function getAll(){

        return $this->execute('SELECT * FROM pages WHERE pages.deleted_at IS NULL', [] );


    }
    public function getAllWhere($name){

        return $this->execute('SELECT * FROM pages WHERE pages.deleted_at IS NULL AND position = ?', [$name] );


    }

    public function get3(){

        return $this->execute('SELECT * FROM pages WHERE pages.deleted_at IS NULL LIMIT 3', [] );


    }

    public function getrest(){

        return $this->execute('SELECT * FROM pages WHERE pages.deleted_at IS NULL LIMIT 100 OFFSET 3', [] );


    }


    public function add(){

        if( !$this->validate() ){

            return redirect('account.php?page=pages&action=add');

        }



        $id = parent::add();

        $this->uploadImages($id);

        return redirect('account.php?page=pages', 'The page has been added');

    }


    public function update($id, $whereValues = null){


        $url ="https://maps.googleapis.com/maps/api/geocode/json?address="."&sensor=false&‌​components=country:UK";
        $data = @file_get_contents($url);
        $result = json_decode($data, true);
        $lat = $result['results'][0]['geometry']['location']['lat'];
        $long = $result['results'][0]['geometry']['location']['lng'];

        $this->lat = $lat;
        $this->long = $long;

        if( !parent::update('id = :id', ['id' => $id]) ){

            return redirect('account.php?page=page&action=edit&id='.$id);

        }

        $this->uploadImages($id);

        return redirect('account.php?page=pages', 'The page has been updated');

    }


    public function delete($id){

        $this->updateRow($this->table, ['deleted_at' => DT], 'id = :id  ', [ 'id' => $id ] );

        return redirect('account.php?page=pages', 'The page has been deleted');


    }

    public function addimg(){

        foreach($_FILES as $key => $file){

            $fileNum = str_replace('file-', '', $key);

            if($_FILES[$key]['size'] > 0){

                $explodedot = explode('.', $_FILES[$key]['name']);
                $ext = $explodedot[sizeof($explodedot)-1];
                $ext = strtolower($ext);

                $size = getimagesize($_FILES[$key]['tmp_name']);

                if(empty($size)){ return redirect( 'account.php?page=add-gallery', 'You must upload a valid image', 'e' ); }

                if ( $ext != "jpg" && $ext != "png" && $ext != "gif" ){ return redirect( 'account.php?page=add-gallery', 'JPG, PNG or GIF extensions only', 'e' );  }

                $this->extension = $ext;

                $id = parent::add();

                move_uploaded_file($_FILES[$key]['tmp_name'], '../gallery/'.$id.'.'.$ext);

            }

        }



        return redirect('account.php?page=gallery', 'The policy image has been added');

    }


    public function deleteImage($image){

        unlink('../gallery/'.$image);

        return redirect( 'account.php?page=policy&action=edit&id='.$_GET['id'], 'The image has been deleted' );

    }


    public function uploadImages($id){

        foreach($_FILES as $key => $file){

            $fileNum = str_replace('file-', '', $key);

            if($_FILES[$key]['size'] > 0){

                $explodedot = explode('.', $_FILES[$key]['name']);
                $ext = $explodedot[sizeof($explodedot)-1];
                $ext = strtolower($ext);

                $size = getimagesize($_FILES[$key]['tmp_name']);

                if(empty($size)){ return redirect( 'account.php?page=gallery&action=edit&id='.$id, 'You must upload a valid image', 'e' ); }

                if ( $ext != "jpg" && $ext != "png" && $ext != "gif" && $ext != "jpeg" ){ return redirect( 'account.php?page=gallery&action=edit&id='.$id, 'JPG, PNG or GIF extensions only', 'e' );  }

                $this->updateRow($this->table, ['extension' => $ext], 'id = :id  ', [ 'id' => $id ] );

                if(file_exists('../gallery/'.$id.'.jpg')){ unlink( '../gallery/'.$id.'.jpg' ); }
                if(file_exists('../gallery/'.$id.'.png')){ unlink( '../gallery/'.$id.'.png' ); }
                if(file_exists('../gallery/'.$id.'.gif')){ unlink( '../gallery/'.$id.'.gif' ); }
                if(file_exists('../gallery/'.$id.'.jpeg')){ unlink( '../gallery/'.$id.'.jpeg' ); }

                move_uploaded_file($_FILES[$key]['tmp_name'], '../gallery/'.$id.'.'.$ext);

            }

        }

    }






}









