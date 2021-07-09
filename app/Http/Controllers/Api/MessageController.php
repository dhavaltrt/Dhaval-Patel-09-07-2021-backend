<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

use App\User;
use App\Message;

class MessageController extends BaseController
{

  // Get all messages
  public function index(Request $request) {    
    try {

      $MessageType = $request->input('message_type') ?: 'received'; // Which type of list users want... default to 'Received' else 'Sent'
      
      $user_id = $request->input('user_id') ?: $request->user()->id; // Which users list to fetch... default to current user

      $user = User::find($user_id);
      if (is_null($user)) {
        return $this->sendError( 'User not found' );
      }

      if ($MessageType == 'received') {
        $messageData = $user->received;
      } else {
        $messageData = $user->sent;
      }

      // Removed deleted messages
      $filtered = $messageData->filter(function ($value, $key) use ($request, $user) {
        return (!in_array($user->id, $value->deleted_array_id));
      })->values();

      return $this->sendResponse( 'Data fetched successfully.', $filtered);
    } catch (Exception $e) {
      return $this->sendError( $e->getMessage() );
    }
  }
  
  // Add new message
  public function store(Request $request) {
    $rules = [
      'sender_id'   => 'required|exists:users,id',
      'receiver_id' => 'required|exists:users,id',
      'subject'     => ['required', 'string', 'max:255'],
      'message'     => 'required',
    ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      $errors = $validator->errors();
      return $this->sendError( implode(', ', $errors->all()) );
    }

    try {
      $messageData = Message::create($request->input());
      return $this->sendResponse( 'Message sent successfully', $messageData );
    } catch (Exception $e) {
      return $this->sendError( $e->getMessage() );
    }
  }

  public function destroy(Request $request, $id = '') {
    
    if($id == '') {
      return $this->sendError( 'Invalid input found' ); 
    }

    try {
      
      // Find message by id
      $messageData = Message::find($id);

      if(!$messageData) {
        return $this->sendError( 'Message not found' );
      }

      // check if already deleted
      if(in_array($request->user()->id, $messageData->deleted_array_id)) {
        return $this->sendError( 'Message has been already deleted' );
      }

      if(count($messageData->deleted_array_id) == 0) {
        $messageData->deleted_by = json_encode([$request->user()->id]);
      } else {
        $oldArray = $messageData->deleted_array_id;
        array_push($oldArray, $request->user()->id); // new id into array
        $messageData->deleted_by = json_encode($oldArray);
      }
      
      // update the message
      $messageData->save();

      return $this->sendResponse( 'Message has been deleted successfully', $messageData );
    } catch (Exception $e) {
      return $this->sendError( $e->getMessage() );
    }
  }

}
