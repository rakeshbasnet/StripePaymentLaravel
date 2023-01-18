<?php

namespace App\Http\Controllers;

use Stripe;
use Session;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function stripePyament(Request $req)
    {
    	//print_r($req->all()); die();
    	Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
		$customer = Stripe\Customer::create(array(
            'address' => [
                'line1' => 'Tinkune,Kathmandu',
                'postal_code' => '44200',
                'city' => 'Kathmandu',
                'state' => 'Bagmati',
                'country' => 'Nepal',
              ],
                "email" => 'rbs@gmail.com',
                "name" =>'RB',
				"source"=>$req->stripeToken,
             ));
    	$data = Stripe\Charge::create([
    			"amount"=>50*100,
    			"currency"=>"usd",
				"customer" => $customer->id,
    			"description"=>"Stripe Payment Test Done By RB",
				'shipping' => [
					'name' => 'RBS',
					'address' => [
					  'line1' => ' tinkune road',
					  'postal_code' => '44200',
					  'city' => 'Kathmandu',
					  'state' => 'Bagmati',
					  'country' => 'Nepal',
					],
				  ],
    	]);

		//We have to save the transaction_id in our Database by using $data->id

    	Session::flash("success","Payment successfully!");

    	return redirect()->back();
    }
}
