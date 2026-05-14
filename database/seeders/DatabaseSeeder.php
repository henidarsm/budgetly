<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Expense;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@budgetly.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'status' => 'active',
            'business_name' => 'Budgetly System',
        ]);

        // Create Demo User
        $user1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'status' => 'active',
            'phone' => '08123456789',
            'business_name' => 'Warung Makan Budi',
        ]);

        $user2 = User::create([
            'name' => 'Siti Rahayu',
            'email' => 'siti@example.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'status' => 'active',
            'phone' => '08987654321',
            'business_name' => 'Toko Kelontong Siti',
        ]);

        // Global Categories (created by admin)
        $globalCats = [
            ['name' => 'Bahan Baku', 'color' => '#1565C0', 'is_global' => true],
            ['name' => 'Operasional', 'color' => '#2E7D32', 'is_global' => true],
            ['name' => 'Gaji Karyawan', 'color' => '#E65100', 'is_global' => true],
            ['name' => 'Pemasaran', 'color' => '#6A1B9A', 'is_global' => true],
            ['name' => 'Utilitas', 'color' => '#00838F', 'is_global' => true],
        ];
        foreach ($globalCats as $cat) {
            Category::create(array_merge($cat, ['user_id' => null]));
        }

        // User-specific categories
        $userCats = Category::whereNull('user_id')->get();

        // Create expenses for user1
        $expenseData = [
            ['title' => 'Pembelian Bahan Baku Sayur', 'amount' => 500000, 'category' => 'Bahan Baku', 'days' => 2],
            ['title' => 'Bayar Listrik Bulan Ini', 'amount' => 350000, 'category' => 'Utilitas', 'days' => 5],
            ['title' => 'Gaji Karyawan Maret', 'amount' => 2500000, 'category' => 'Gaji Karyawan', 'days' => 7],
            ['title' => 'Beli Kompor Gas Baru', 'amount' => 800000, 'category' => 'Operasional', 'days' => 10],
            ['title' => 'Iklan Media Sosial', 'amount' => 200000, 'category' => 'Pemasaran', 'days' => 12],
            ['title' => 'Bahan Baku Daging', 'amount' => 1200000, 'category' => 'Bahan Baku', 'days' => 15],
            ['title' => 'Bayar Air PAM', 'amount' => 120000, 'category' => 'Utilitas', 'days' => 18],
            ['title' => 'Perbaikan Peralatan', 'amount' => 450000, 'category' => 'Operasional', 'days' => 20],
            ['title' => 'Promosi Brosur', 'amount' => 150000, 'category' => 'Pemasaran', 'days' => 22],
            ['title' => 'Bahan Bumbu Dapur', 'amount' => 300000, 'category' => 'Bahan Baku', 'days' => 25],
            ['title' => 'Bayar Sewa Tempat', 'amount' => 1500000, 'category' => 'Operasional', 'days' => 28],
            ['title' => 'Gaji Karyawan April', 'amount' => 2500000, 'category' => 'Gaji Karyawan', 'days' => 32],
            ['title' => 'Bahan Baku Mingguan', 'amount' => 650000, 'category' => 'Bahan Baku', 'days' => 35],
            ['title' => 'Bayar Internet', 'amount' => 200000, 'category' => 'Utilitas', 'days' => 38],
            ['title' => 'Iklan Google Ads', 'amount' => 300000, 'category' => 'Pemasaran', 'days' => 40],
        ];

        foreach ($expenseData as $exp) {
            $cat = $userCats->where('name', $exp['category'])->first();
            Expense::create([
                'user_id' => $user1->id,
                'category_id' => $cat->id,
                'title' => $exp['title'],
                'amount' => $exp['amount'],
                'expense_date' => Carbon::now()->subDays($exp['days'])->format('Y-m-d'),
                'description' => 'Pengeluaran ' . $exp['title'],
            ]);
        }

        // Expenses for user2
        $expenseData2 = [
            ['title' => 'Stok Barang Bulanan', 'amount' => 3000000, 'category' => 'Bahan Baku', 'days' => 3],
            ['title' => 'Bayar Listrik Toko', 'amount' => 280000, 'category' => 'Utilitas', 'days' => 8],
            ['title' => 'Gaji Asisten Toko', 'amount' => 1800000, 'category' => 'Gaji Karyawan', 'days' => 11],
            ['title' => 'Renovasi Etalase', 'amount' => 950000, 'category' => 'Operasional', 'days' => 14],
            ['title' => 'Spanduk Toko Baru', 'amount' => 180000, 'category' => 'Pemasaran', 'days' => 17],
        ];
        foreach ($expenseData2 as $exp) {
            $cat = $userCats->where('name', $exp['category'])->first();
            Expense::create([
                'user_id' => $user2->id,
                'category_id' => $cat->id,
                'title' => $exp['title'],
                'amount' => $exp['amount'],
                'expense_date' => Carbon::now()->subDays($exp['days'])->format('Y-m-d'),
                'description' => 'Pengeluaran ' . $exp['title'],
            ]);
        }
    }
}
