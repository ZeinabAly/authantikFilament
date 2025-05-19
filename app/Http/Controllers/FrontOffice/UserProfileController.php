<?php

namespace App\Http\Controllers\FrontOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use Illuminate\Support\Facades\File;
use App\Services\ImageStockageService;

use App\Models\{Order, Transaction, Reservation, Notification};
class UserProfileController extends Controller
{
    protected $imageStockageService;
    public function __construct(ImageStockageService $imageStockageService){
        $this->imageStockageService = $imageStockageService;
    }

    public function index(){
        $user = auth()->user();
        return view('pagesInterfaceFront.userProfile.index');
        // return view('pagesInterfaceFront.userProfile.monCompte', compact('user'));
    }

    public function monCompte(){
        $user = auth()->user();
        return view('pagesInterfaceFront.userProfile.monCompte', compact('user'));
    }

    // Modifier les informations
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('myprofile.monCompte')->with('status', 'Profil modifié');
    }

    public function updateImage(Request $request){
        $request->validate(
            ['image' => ['nullable','mimes:png,jpeg,webp,jpg'],]
        );
        $user = auth()->user();

        if($request->hasFile('image')){

            if(File::exists(public_path('uploads/usersImages').'/'.$user->image)){
                File::delete(public_path('uploads/usersImages').'/'.$user->image);
            }
            if(File::exists(public_path('uploads/usersImages/thumbnails').'/'.$user->image)){
                File::delete(public_path('uploads/usersImages/thumbnails').'/'.$user->image);
            }
            
            // ENREGISTREMENT DES IMAGES
            $image = $request->file('image');
            $imageName = $this->imageStockageService->generateImages("usersImages", $image);
            $this->imageStockageService->generateThumbnailsImages("usersImages", $image);
            $user->image = $imageName;
        }

        $user->save();
        return Redirect::route('myprofile.monCompte')->with('status', 'Photo modifiée');

    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function orders(){
        $orders = Order::all();
        return view('pagesInterfaceFront.userProfile.mesCommandes', compact('orders'));
    }

    public function detailsCmd(Order $order){
        $orderItems = $order->orderItems;
        $transaction = Transaction::where('order_id', $order->id)->first();
        return view('pagesInterfaceFront.userProfile.order-details', compact('order', 'orderItems', 'transaction'));
    }

    public function reservations(){
        $reservations = Reservation::all();
        return view('pagesInterfaceFront.userProfile.mesReservations', compact('reservations'));
    }

    public function notifications(){
        $notifications =  auth()->user()->notifications()->paginate(8);
        
        return view('pagesInterfaceFront.userProfile.mesNotifications', compact('notifications'));
    }

    
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        
        return back()->with('status', 'Notification marquée comme lue.');
    }

    public function deleteNotif($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();
        
        return back()->with('status', 'Notification supprimée.');
    }
}
