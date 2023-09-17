<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function categoryList(){
        $categories = Category::when(request('searchkey'),function($query){
                            $query -> where('category_name','like','%'.request('searchkey').'%');
                        })->orderBy('id','DESC')->get();
        return view('admin.category.categoryList',compact('categories'));
    }

    public function orderCategory(Request $req){
        $order = $req->order;
        logger($order);
        $response = Category::when(request('searchkey'),function($query){
                                $query -> where('category_name','like','%'.request('searchkey').'%');
                                logger(request('searchkey'));
                            })->when($order == 'id',function($query){
                                $query -> orderBy('id','DESC');
                            })->when($order == 'lastUpdate',function($query){
                                $query -> orderBy('updated_at','DESC');
                            })->when($order == 'interest',function($query){
                                $query -> orderBy('id','ASC');
                            })->get();
        logger($response);
        return response()->json($response,200);
    }

    //create update category start
    public function createCategoryPage(){
        return view('admin.category.categorycreate');
    }

    public function updateCategoryPage($id){
        $category = Category::where('id',$id)->first();
        return view('admin.category.categoryupdate',compact('category'));
    }

    public function CU_Category(Request $req){
        $validationCheck = $this->validateCat($req);
        if($validationCheck->fails()){
            return back()->withErrors($validationCheck)->withInput();
        }
        $datapack = $this->dataArray($req);
        if($req->id){
            //update
            Category::where('id',$req->id)->update($datapack);
            return redirect()->route('admin#categorylist')->with(['success'=>'Category updated successfully..']);
        }else{
            //create
            Category::create($datapack);
            return redirect()->route('admin#categorylist')->with(['success'=>'Category created successfully..']);
        }
    }

    private function validateCat($data){
        $validData = [
            'name' => 'required|unique:categories,category_name,'.$data->id,
            'description' => 'required'
        ];
        $validMsg = [
            'name.required'=> 'Category Name is required.',
            'name.unique'=> 'A category with this name has already existed.',
            'description.required' => 'Category Description is required.'
        ];
        return Validator::make($data->all(),$validData,$validMsg);
    }

    private function dataArray($data){
        $datapack = [
            'category_name' => $data->name,
            'category_description' => $data->description
        ];
        return $datapack;
    }
    //create update category end


    //delete category start

    public function deleteCategory($id){
        Category::where('id',$id)->delete();
        return redirect()->route('admin#categorylist');
    }
    //delete category end


    //API start

    //API end

}
