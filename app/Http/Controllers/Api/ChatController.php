<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ChatController extends Controller
{
    public function conversations(Request $request)
    {
        $q = $request->q;

        try {
            $conversations = Conversation::with(['users', 'latestMessage'])
                ->when($q, function ($query) use ($q) {
                    $query->where(function ($subQuery) use ($q) {
                        $subQuery->whereHas('users.user', function ($qUser) use ($q) {
                            $qUser->where('name', 'like', '%' . $q . '%')
                                ->orWhere('nim', 'like', '%' . $q . '%');
                        })
                            ->orWhere('title', 'like', '%' . $q . '%');
                    });
                })
                ->get();

            return response()->json([
                'response' => 200,
                'success' => true,
                'message' => 'Data conversations berhasil diambil',
                'data' => ConversationResource::collection($conversations)
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => 500,
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data conversations: ' . $th->getMessage(),
                'data' => null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function storeConversation(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'type' => 'required|in:private,group',
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'participant_ids' => 'required|array|min:1',
                'participant_ids.*' => 'exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'response' => Response::HTTP_BAD_REQUEST,
                    'success' => false,
                    'message' => 'Validation error occurred',
                    'validation' => $validator->errors(),
                    'data' => null
                ], Response::HTTP_BAD_REQUEST);
            }

            $conversation = Conversation::create([
                'type' => $request->input('type'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
            ]);

            // Tambahkan pengguna yang membuat percakapan
            $conversation->users()->create([
                'user_id' => Auth::id(),
            ]);

            // Tambahkan peserta lainnya
            foreach ($request->input('participant_ids') as $participantId) {
                $conversation->users()->create([
                    'user_id' => $participantId,
                ]);
            }

            return response()->json([
                'response' => Response::HTTP_CREATED,
                'success' => true,
                'message' => 'Conversation created successfully',
                'validation' => [],
                'data' => new ConversationResource($conversation),
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'success' => false,
                'message' => 'An error occurred while creating the conversation: ' . $th->getMessage(),
                'validation' => [],
                'data' => null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function messages(Request $request, $conversationId)
    {
        try {
            $perPage = 30; // Jumlah pesan per halaman
            $message = ConversationMessage::with(['sender', 'attachments', 'statuses'])
                ->where('conversation_id', $conversationId)
                ->orderBy('created_at', 'asc')
                ->paginate($perPage);

            return response()->json([
                'response' => 200,
                'success' => true,
                'message' => 'Data messages berhasil diambil',
                'data' => MessageResource::collection($message)
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => 500,
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data messages: ' . $th->getMessage(),
                'data' => null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function sendMessage(Request $request, $conversationId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'content' => 'required|string',
            ], [
                'content.required' => 'Pesan tidak boleh kosong.',
                'content.string' => 'Pesan harus berupa teks.',
            ]);
            $validation = array_fill_keys(array_keys($request->all()), []);

            if ($validator->fails()) {
                foreach ($validator->errors()->toArray() as $key => $errors) {
                    $validation[$key] = $errors;
                }
                return response()->json([
                    'response' => Response::HTTP_BAD_REQUEST,
                    'success' => false,
                    'message' => 'Validation error occurred',
                    'validation' => $validation,
                    'data' => null
                ], Response::HTTP_BAD_REQUEST);
            }

            $message = ConversationMessage::create([
                'conversation_id' => $conversationId,
                'sender_id' => Auth::id(),
                'content' => $request->input('content'),
            ]);
            return response()->json([
                'response' => Response::HTTP_CREATED,
                'success' => true,
                'message' => 'Message sent successfully',
                'validation' => [],
                'data' => new MessageResource($message),
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {

            return response()->json([
                'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'success' => false,
                'message' => 'An error occurred while sending the message: ' . $th->getMessage(),
                'validation' => [],
                'data' => null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
