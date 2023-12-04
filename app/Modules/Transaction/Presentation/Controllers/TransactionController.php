<?php

namespace App\Modules\Transaction\Presentation\Controllers;

use App\Modules\Transaction\Core\Application\Service\TransactionService;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransactionController
{
    private $formData = [];
    private $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        $transactions = $this->transactionService->getOngoingTransactions();
        $locations = $this->transactionService->getAllLocations();

        return view('transaction::index', compact('transactions', 'locations'));
    }

    public function create()
    {
        $members = $this->transactionService->getAllMembers();

        $locations = $this->transactionService->getAllLocations();

        $menus = $this->transactionService->getAllMenus();

        $promos = $this->transactionService->getAllPromos();

        return view ('transaction::create', compact('members', 'locations', 'menus', 'promos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user' => 'required|exists:users,id',
            'address' => 'required|exists:locations,id',
            'total_price' => 'required|numeric',
            'noMeja' => 'required|numeric',
            'notes' => 'nullable|string',
            'promo' => 'nullable|exists:promos,id',
        ]);

        $data = [
            'waktu' => Carbon::now('Asia/Bangkok'),
            'keterangan' => $request->input('notes'),
            'hargaTotal' => $request->input('total_price'),
            'statusTransaksi' => "Sedang Berjalan",
            'noMeja' => $request->input('noMeja'),
            'isReservasi' => False,
            'promo_id' => $request->input('promo'),
            'user_id' => $request->input('user'),
            'location_id' => $request->input('address'),
        ];

        $transaction = $this->transactionService->createTransaction($data);

        for ($i = 0; $i < $request->input('menu_count'); $i++) {
            $orderData = [
                'quantity' => json_decode($request->input('quantities')[0])[$i],
                'transaction_id' => $transaction->id,
                'menu_id' => json_decode($request->input('menu_ids')[0])[$i],
            ];
            $this->transactionService->createOrder($orderData);
        }

        Cache::forget('ongoingTransactions');        

        return redirect()->route('transaction.index')->with('success', 'Transaction created successfully');
    }

    public function edit($id)
    {
        $transaction = $this->transactionService->getTransactionById($id);
        $orders = $this->transactionService->getOrdersById($id);
        $locations = $this->transactionService->getAllLocations();
        $menus = $this->transactionService->getAllMenus();
        $promos = $this->transactionService->getAllPromos();
        $members = $this->transactionService->getAllMembers();

        if((Auth::user()->role != 'pemilik') && (Auth::user()->location_id != $transaction->location_id))
        {
            return redirect()->route('transaction.index')->with('error', 'You do not have permission to edit this reservation');
        }

        return view('transaction::edit', compact('transaction', 'orders', 'locations', 'menus', 'promos', 'members'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'user' => 'exists:users,id',
            'address' => 'exists:locations,id',
            'total_price' => 'numeric',
            'noMeja' => 'numeric',
            'notes' => 'nullable|string',
            'promo' => 'nullable|exists:promos,id',
        ]);

        $transaction = $this->transactionService->getTransactionById($id);

        if((Auth::user()->role != 'pemilik') && (Auth::user()->location_id != $transaction->location_id))
        {
            return redirect()->route('transaction.index')->with('error', 'You do not have permission to edit this reservation');
        }

        $data = [
            'waktu' => $transaction->waktu,
            'keterangan' => $request->input('notes', $transaction->keterangan),
            'hargaTotal' => $request->input('total_price', $transaction->hargaTotal),
            'statusTransaksi' => $request->input('transaction_status', $transaction->statusTransaksi),
            'noMeja' => $request->input('noMeja', $transaction->noMeja),
            'isReservasi' => False,
            'promo_id' => $request->input('promo', $transaction->promo_id),
            'user_id' => $request->input('user', $transaction->user_id),
            'location_id' => $transaction->location_id,
        ];

        $this->transactionService->updateTransaction($id, $data);

        $this->transactionService->deleteOrder($id);

        $menuCount = count($request->input('menu_ids'));
        
        for ($i = 0; $i < $request->input('menu_count'); $i++) {
            $orderData = [
                'quantity' => json_decode($request->input('quantities')[0])[$i],
                'transaction_id' => $id,
                'menu_id' => json_decode($request->input('menu_ids')[0])[$i],
            ];
            $this->transactionService->createOrder($orderData);
        }

        Cache::forget('ongoingTransactions');
        Cache::forget('completedTransactions');
        Cache::forget('transactions:' . $id);
        Cache::forget('orders: ' . $id);

        return redirect()->route('transaction.index')->with('success', 'Transaction has been updated');    
    }

    public function detail($id)
    {
        $transaction = $this->transactionService->getTransactionById($id);
        $orders = $this->transactionService->getOrdersById($id);
        $promo = $this->transactionService->getPromoById($id);

        if((Auth::user()->role != 'pemilik') && (Auth::user()->location_id != $transaction->location_id))
        {
            return redirect()->route('transaction.index')->with('error', 'You do not have permission to view this transaction');
        }

        return view('transaction::detail', compact('transaction', 'orders', 'promo'));
    }

    public function destroy($id)
    {
        $transaction = $this->transactionService->getTransactionById($id);
        if((Auth::user()->role != 'pemilik') && (Auth::user()->location_id != $transaction->location_id))
        {   
            return redirect()->route('transaction.index')->with('error', 'You do not have permission to delete this reservation');
        }

        $this->transactionService->deleteOrder($id);
        $this->transactionService->deleteTransaction($id);

        Cache::forget('ongoingTransactions');
        Cache::forget('completedTransactions');
        
        return redirect()->route('transaction.index')->with('success', 'Reservation deleted successfully');
    }
}