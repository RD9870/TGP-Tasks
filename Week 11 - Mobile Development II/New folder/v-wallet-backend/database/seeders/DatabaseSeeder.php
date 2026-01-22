<?php

namespace Database\Seeders;

// use App\Models\Transfer;
use App\Models\Transfer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Ahmed Sender',
            'phone' => '0912345678',
            'password' => Hash::make('password123'),
            'balance' => 5000,
        ]);


        User::create([
            'name' => 'Mohamed Receiver',
            'phone' => '01022222222',
            'password' => Hash::make('password123'),
            'balance' => 100,
        ]);
         User::create([
        'name' => 'Sara Ali',
        'phone' => '01033333333',
        'password' => Hash::make('password123'),
        'balance' => 800,
    ]);

    User::create([
        'name' => 'Omar Khaled',
        'phone' => '01044444444',
        'password' => Hash::make('password123'),
        'balance' => 1200,
    ]);

    User::create([
        'name' => 'Lina Hassan',
        'phone' => '01055555555',
        'password' => Hash::make('password123'),
        'balance' => 300,
    ]);

    User::create([
        'name' => 'Youssef Tarek',
        'phone' => '01066666666',
        'password' => Hash::make('password123'),
        'balance' => 1500,
    ]);

    Transfer::create([
                        'id'          => Str::uuid(),
                'sender_id'   => 1,
                'receiver_id' => 2,
                'amount'      => 200,
                'status'      => 'completed',
                'expires_at'  => Carbon::now(),
    ]);

    Transfer::create([
                        'id'          => Str::uuid(),

                'sender_id'   => 1,
                'receiver_id' => 2,
                'amount'      => 200,
                'status'      => 'completed',
                'expires_at'  => Carbon::now(),
    ]);


    Transfer::create([
                        'id'          => Str::uuid(),

                'sender_id'   => 1,
                'receiver_id' => 2,
                'amount'      => 200,
                'status'      => 'completed',
                'expires_at'  => Carbon::now(),
    ]);


    Transfer::create([

                'id'          => Str::uuid(),

                'sender_id'   => 1,
                'receiver_id' => 2,
                'amount'      => 200,
                'status'      => 'completed',
                'expires_at'  => Carbon::now(),
    ]);

    Transfer::create([
                        'id'          => Str::uuid(),

                'sender_id'   => 1,
                'receiver_id' => 2,
                'amount'      => 200,
                'status'      => 'completed',
                'expires_at'  => Carbon::now(),
    ]);

    Transfer::create([
                        'id'          => Str::uuid(),

        'sender_id' => 4,
        'receiver_id' => 1,
        'amount' => 100,
        'status' => 'pending',
        'expires_at' => Carbon::now()->addMinutes(1),
    ]);

        Transfer::create([
                            'id'          => Str::uuid(),

        'sender_id' => 4,
        'receiver_id' => 1,
        'amount' => 100,
        'status' => 'completed',
        'expires_at' => Carbon::now(),
    ]);
    Transfer::create([
                        'id'          => Str::uuid(),
                'sender_id'   => 1,
                'receiver_id' => 2,
                'amount'      => 200,
                'status'      => 'completed',
                'expires_at'  => Carbon::now(),
    ]);

    Transfer::create([
                        'id'          => Str::uuid(),

                'sender_id'   => 1,
                'receiver_id' => 2,
                'amount'      => 200,
                'status'      => 'completed',
                'expires_at'  => Carbon::now(),
    ]);


    Transfer::create([
                        'id'          => Str::uuid(),

                'sender_id'   => 1,
                'receiver_id' => 2,
                'amount'      => 200,
                'status'      => 'completed',
                'expires_at'  => Carbon::now(),
    ]);


    Transfer::create([

                'id'          => Str::uuid(),

                'sender_id'   => 1,
                'receiver_id' => 2,
                'amount'      => 200,
                'status'      => 'completed',
                'expires_at'  => Carbon::now(),
    ]);

    Transfer::create([
                        'id'          => Str::uuid(),

                'sender_id'   => 1,
                'receiver_id' => 2,
                'amount'      => 200,
                'status'      => 'completed',
                'expires_at'  => Carbon::now(),
    ]);

    Transfer::create([
                        'id'          => Str::uuid(),

        'sender_id' => 4,
        'receiver_id' => 1,
        'amount' => 100,
        'status' => 'pending',
        'expires_at' => Carbon::now()->addMinutes(1),
    ]);

        Transfer::create([
                            'id'          => Str::uuid(),

        'sender_id' => 4,
        'receiver_id' => 1,
        'amount' => 100,
        'status' => 'completed',
        'expires_at' => Carbon::now(),
    ]);
    Transfer::create([
                        'id'          => Str::uuid(),
                'sender_id'   => 1,
                'receiver_id' => 2,
                'amount'      => 200,
                'status'      => 'completed',
                'expires_at'  => Carbon::now(),
    ]);

    Transfer::create([
                        'id'          => Str::uuid(),

                'sender_id'   => 1,
                'receiver_id' => 2,
                'amount'      => 200,
                'status'      => 'completed',
                'expires_at'  => Carbon::now(),
    ]);


    Transfer::create([
                        'id'          => Str::uuid(),

                'sender_id'   => 1,
                'receiver_id' => 2,
                'amount'      => 200,
                'status'      => 'completed',
                'expires_at'  => Carbon::now(),
    ]);


    Transfer::create([

                'id'          => Str::uuid(),

                'sender_id'   => 1,
                'receiver_id' => 2,
                'amount'      => 200,
                'status'      => 'completed',
                'expires_at'  => Carbon::now(),
    ]);

    Transfer::create([
                        'id'          => Str::uuid(),

                'sender_id'   => 1,
                'receiver_id' => 2,
                'amount'      => 200,
                'status'      => 'completed',
                'expires_at'  => Carbon::now(),
    ]);

    Transfer::create([
                        'id'          => Str::uuid(),

        'sender_id' => 4,
        'receiver_id' => 1,
        'amount' => 100,
        'status' => 'pending',
        'expires_at' => Carbon::now()->addMinutes(1),
    ]);

        Transfer::create([
                            'id'          => Str::uuid(),

        'sender_id' => 4,
        'receiver_id' => 1,
        'amount' => 100,
        'status' => 'completed',
        'expires_at' => Carbon::now(),
    ]);
    Transfer::create([
                        'id'          => Str::uuid(),
                'sender_id'   => 1,
                'receiver_id' => 2,
                'amount'      => 200,
                'status'      => 'completed',
                'expires_at'  => Carbon::now(),
    ]);

    Transfer::create([
                        'id'          => Str::uuid(),

                'sender_id'   => 1,
                'receiver_id' => 2,
                'amount'      => 200,
                'status'      => 'completed',
                'expires_at'  => Carbon::now(),
    ]);


    Transfer::create([
                        'id'          => Str::uuid(),

                'sender_id'   => 1,
                'receiver_id' => 2,
                'amount'      => 200,
                'status'      => 'completed',
                'expires_at'  => Carbon::now(),
    ]);


    Transfer::create([

                'id'          => Str::uuid(),

                'sender_id'   => 1,
                'receiver_id' => 2,
                'amount'      => 200,
                'status'      => 'completed',
                'expires_at'  => Carbon::now(),
    ]);

    Transfer::create([
                        'id'          => Str::uuid(),

                'sender_id'   => 1,
                'receiver_id' => 2,
                'amount'      => 200,
                'status'      => 'completed',
                'expires_at'  => Carbon::now(),
    ]);

    Transfer::create([
                        'id'          => Str::uuid(),

        'sender_id' => 4,
        'receiver_id' => 1,
        'amount' => 100,
        'status' => 'pending',
        'expires_at' => Carbon::now()->addMinutes(1),
    ]);

        Transfer::create([
                            'id'          => Str::uuid(),

        'sender_id' => 4,
        'receiver_id' => 1,
        'amount' => 100,
        'status' => 'completed',
        'expires_at' => Carbon::now(),
    ]);
    }
}
