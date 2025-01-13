<?php

namespace App\Http\Controllers;

use App\Events\ChangeQuestion;
use App\Events\UpdatePoint;
use App\Jobs\SendChangeQuestion;
use App\Jobs\SendUpdatePoint;
use App\Models\Jawaban;
use App\Models\Message;
use App\Models\Pendamping;
use App\Models\Pertanyaan;
use App\Models\Peserta;
use App\Models\Point;
use App\Models\Provinsi;
use App\Models\Sekolah;
use App\Models\Tema;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MobileController extends Controller
{
    public function getAllData()
    {
        return response()->json(Jawaban::with('pertanyaan')->get(), 200);
    }

    public function get_jawabans()
    {
        return response()->json(Jawaban::with('pertanyaan')->get(), 200);
    }

    public function get_pendampings()
    {
        return response()->json(Pendamping::with('sekolah')->get(), 200);
    }

    public function get_pertanyaans()
    {
        return response()->json(Pertanyaan::with(['tema', 'jawabans'])->get(), 200);
    }

    public function send_change_question()
    {
        // Get all messages and append time and sender
        $question = Pertanyaan::get();

        // Check if question are not empty and get the latest message
        if ($question->isNotEmpty()) {
            $latestQuestion = $question->last(); // Get the last message in the list

            // Dispatch SendMessage only for the latest message
            SendChangeQuestion::dispatch($latestQuestion);
            ChangeQuestion::dispatch([]);
        }

        // Return the updated list of question
        return response()->json($question);
    }

    public function get_pesertas()
    {
        return response()->json(Peserta::with('sekolah')->get(), 200);
    }

    public function get_points()
    {
        return response()->json(Point::with('sekolah')->get(), 200);
    }

    public function send_update_point()
    {    
        $point = Point::get();

        if ($point->isNotEmpty()) {
            $latestPoint = $point->last(); // Get the last message in the list
            
            SendUpdatePoint::dispatch($latestPoint);
            UpdatePoint::dispatch([]);
        }

        return response()->json($point);
    }


    public function get_provinsis()
    {
        return response()->json(Provinsi::with(['sekolahs', 'temas', 'user'])->get(), 200);
    }

    public function get_sekolahs()
    {
        return response()->json(Sekolah::with(['provinsi', 
        // 'pesertas', 'pendampings', 
        'points'])->get(), 200);
    }

    public function get_temas()
    {
        return response()->json(Tema::with(['provinsi', 'pertanyaans'])->get(), 200);
    }

    public function get_users()
    {
        return response()->json(User::with('provinsi')->get(), 200);
    }
}


// <?php

// namespace App\Http\Controllers;

// use App\Jobs\SendMessage;
// use App\Models\Message;
// use Illuminate\Http\JsonResponse;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// use App\Events\GotMessage;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Foundation\Bus\Dispatchable;
// use Illuminate\Foundation\Queue\Queueable;
// use Illuminate\Queue\InteractsWithQueue;
// use Illuminate\Queue\SerializesModels;


// class MessageController extends Controller
// {
//     /**
//      * Get the list of messages and dispatch the latest one.
//      */
//     public function index(): JsonResponse
//     {
//         // Get messages and append time and sender
//         $messages = Message::get()->append(['time', 'sender']);        
//         return response()->json($messages);
//     }

//     /**
//      * Store a new message and dispatch it to the job queue.
//      */
//     public function store(Request $request): JsonResponse
//     {
//         $message = Message::create([
//             'user_id' => Auth::user()->id,
//             'text' => $request->get('text'),
//         ]);

//         // Dispatch only the latest message for efficiency
//         SendMessage::dispatch($message);

//         return response()->json([
//             'success' => true,
//             'message' => 'Message created and job dispatched',
//         ]);
//     }

//     /**
//      * Store a new message with a specific user ID and dispatch it.
//      */
//     public function storeMessage(Request $request): JsonResponse
//     {
//         $message = Message::create([
//             'user_id' => $request->get('user_id'),
//             'text' => $request->get('text'),
//         ]);

//         // Dispatch only the latest message for efficiency
//         SendMessage::dispatch($message);

//         return response()->json([
//             'success' => true,
//             'message' => 'Message created and job dispatched',
//         ]);
//     }

//     public function refreshMessages(): JsonResponse
//     {
//         // Get all messages and append time and sender
//         $messages = Message::get()->append(['time', 'sender']);

//         // Check if messages are not empty and get the latest message
//         if ($messages->isNotEmpty()) {
//             $latestMessage = $messages->last(); // Get the last message in the list

//             // Dispatch SendMessage only for the latest message
//             SendMessage::dispatch($latestMessage);
//             GotMessage::dispatch([]);
//         }

//         // Return the updated list of messages
//         return response()->json($messages);
//     }
// }
