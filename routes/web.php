<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProtechHome;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//subdomain
//Route::domain('{user}.localhost')->group(function(){
//   Route::get('/','ProtechHome@userPost');
//});

Route::controller(ProtechHome::class)->group(function () {
    Route::get('/page/{user}','userPost');
    Route::get('/', 'index');
    //get catagory post
    Route::get('/catagory','getCatagoryPosts');
    Route::get("/page/{user}/catagory",'userPost');
    Route::get('/blog/{id}','read');
    //like post
    Route::post('/like/{id}','like');
    //subscribe users
    Route::post('/subscribe','subscribe');
    //member
    Route::get('/member','ProtechHome@becomeMember');
});

Route::controller(BlogReaderController::class)->group(function () {
    //commwnt on posts
    Route::post('/comment','BlogReaderController@insertComment');
});
//home
 //->middleware('Cros');
//Route::get('/api', 'ProtechHome@api');


//reading post

Route::get('/lib',function(){
   return view('library'); 
});

Route::group(['middleware'=>['auth','verified']],function(){
    Route::get('/blog/trash/{id}','ProtechHome@readTrash');
    //upload image
    Route::post('/upload','blogActionController@uploadBlogImg');
    //delete routes
    Route::post('/delete/{id}','blogActionController@delete');
//    Route::DELETE('/delete/{id}','blogActionController@delete');
    //restore post
    Route::post('/restore/{id}','blogActionController@restore');
    //delete trashed post
//    Route::DELETE('/delete/trash/{id}','blogActionController@permanentDelete');
    Route::post('/delete/trash/{id}','blogActionController@permanentDelete');
});
//admin dashboard
Route::group(['prefix'=>'dashboard','middleware'=>['auth','verified']],function(){
    //member requests 
    Route::get('/','AdminDashboard@index');
    Route::get('search','AdminDashboard@searchMember');
    Route::post('email','AdminDashboard@emailUser');
    Route::get('members','AdminDashboard@members');
    Route::get('getuser','AdminDashboard@user');
    Route::post('ban','AdminDashboard@ban');
    Route::post('deleteuserpost','AdminDashboard@deleteUserPost');
    //get all blog images for user
    Route::get('album','blogActionController@getUserPostAlbum');
    Route::get('allblog','AdminDashboard@allBlogs');
    Route::get('trashes','AdminDashboard@trashes');
    Route::get('profile','AdminDashboard@editProfile');
    Route::get('newblog','AdminDashboard@createBlog');
    Route::post('createnewblog','blogActionController@create');
    Route::get('edit/{id}','blogActionController@edit');
    Route::get('edit/trash/{id}','blogActionController@trashedit');
    
    //user ino editor
    Route::post('userinfo','UserInfoEditor@UpadateUserInfo');
    Route::post('userinfo/upload','UserInfoEditor@UploadProfilePicture');
    //catagores
    Route::get('catagories','AdminDashboard@catagories');
    Route::post('catagories','AdminDashboard@addCatagory');
    Route::post('catagories/{id}','AdminDashboard@deleteCatagory');
//    Route::DELETE('catagories/{id}','AdminDashboard@deleteCatagory');
    //Notification
    Route::get('notifications','AdminDashboard@notifications');
    //get comment
    Route::get('comment/{blogid}/{notification_id}','BlogReaderController@getComment');
});

Auth::routes();
Auth::routes(['verify'=>true]);
Route::get('/home', 'ProtechHome@index')->name('home');
