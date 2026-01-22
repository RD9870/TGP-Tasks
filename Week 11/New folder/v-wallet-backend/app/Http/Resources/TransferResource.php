<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class TransferResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $userId = Auth::user()->id;
        $isSender = $this->sender_id === $userId;
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'status' => $this->status,
            'date' => $this->created_at->format('d M Y H:i'),
            'transaction_type' => $isSender ? 'transfered' : 'received',
            'participant' => $isSender ? $this->receiver->name : $this->sender->name,
            'sender' => $this->sender,
            'receiver' => $this->receiver,
        ];
    }
}
