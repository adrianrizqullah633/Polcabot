<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class WidgetManagementController extends Controller
{
    /**
     * Tampilkan halaman widget management
     */
    public function index()
    {
        $widget = DB::table('widget_settings')->first();
        
        // Generate default widget jika belum ada
        if (!$widget) {
            $widgetKey = 'pk_' . Str::random(32);
            $adminCode = Str::random(12);
            
            DB::table('widget_settings')->insert([
                'widget_key' => $widgetKey,
                'admin_code_hash' => Hash::make($adminCode),
                'widget_title' => 'PolCaBot',
                'widget_subtitle' => 'Asisten Virtual Kampus',
                'primary_color' => '#3b82f6',
                'position' => 'bottom-right',
                'welcome_message' => 'Halo! Ada yang bisa saya bantu?',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Simpan admin code sementara untuk ditampilkan
            session()->flash('new_admin_code', $adminCode);
            
            $widget = DB::table('widget_settings')->first();
        }
        
        return view('admin.widget.index', compact('widget'));
    }

    /**
     * Generate widget key baru
     */
    public function generateKey(Request $request)
    {
        try {
            $widgetKey = 'pk_' . Str::random(32);
            $adminCode = Str::random(12);
            
            DB::table('widget_settings')
                ->where('id', $request->widget_id)
                ->update([
                    'widget_key' => $widgetKey,
                    'admin_code_hash' => Hash::make($adminCode),
                    'updated_at' => now(),
                ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Widget key berhasil di-generate',
                'widget_key' => $widgetKey,
                'admin_code' => $adminCode
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal generate widget key'
            ], 500);
        }
    }

    /**
     * Regenerate admin code
     */
    public function regenerateAdminCode(Request $request)
    {
        try {
            $adminCode = Str::random(12);
            
            DB::table('widget_settings')
                ->where('id', $request->widget_id)
                ->update([
                    'admin_code_hash' => Hash::make($adminCode),
                    'updated_at' => now(),
                ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Admin code berhasil di-regenerate',
                'admin_code' => $adminCode
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal regenerate admin code'
            ], 500);
        }
    }

    /**
     * Update widget settings
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'widget_title' => 'required|string|max:100',
            'widget_subtitle' => 'required|string|max:200',
            'primary_color' => 'required|string|max:20',
            'position' => 'required|in:bottom-right,bottom-left',
            'welcome_message' => 'nullable|string|max:300',
            'is_active' => 'boolean',
        ]);

        try {
            DB::table('widget_settings')
                ->where('id', $request->widget_id)
                ->update([
                    'widget_title' => $request->widget_title,
                    'widget_subtitle' => $request->widget_subtitle,
                    'primary_color' => $request->primary_color,
                    'position' => $request->position,
                    'welcome_message' => $request->welcome_message,
                    'is_active' => $request->has('is_active'),
                    'updated_at' => now(),
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Pengaturan widget berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui pengaturan'
            ], 500);
        }
    }

    /**
     * Statistik penggunaan widget
     */
    public function statistics(Request $request)
    {
        $widgetId = $request->input('widget_id');
        $period = $request->input('period', 7); // default 7 hari
        
        $stats = DB::table('widget_statistics')
            ->where('widget_id', $widgetId)
            ->where('request_date', '>=', now()->subDays($period))
            ->select(
                'request_date',
                DB::raw('SUM(request_count) as total_requests'),
                DB::raw('SUM(CASE WHEN source_type = "kb" THEN request_count ELSE 0 END) as kb_requests'),
                DB::raw('SUM(CASE WHEN source_type = "ai" THEN request_count ELSE 0 END) as ai_requests')
            )
            ->groupBy('request_date')
            ->orderBy('request_date', 'asc')
            ->get();
        
        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }
}