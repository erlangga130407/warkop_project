<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * DateTime Helper untuk Warkop Abah
 * Menangani format tanggal dan waktu realtime
 */

if (!function_exists('get_current_datetime')) {
    /**
     * Mendapatkan datetime saat ini dalam format yang konsisten
     * @param string $format Format datetime (default: Y-m-d H:i:s)
     * @return string
     */
    function get_current_datetime($format = 'Y-m-d H:i:s')
    {
        // Set timezone ke Asia/Jakarta
        date_default_timezone_set('Asia/Jakarta');
        return date($format);
    }
}

if (!function_exists('format_datetime')) {
    /**
     * Format datetime ke format Indonesia
     * @param string $datetime Datetime string
     * @param string $format Format output (default: d/m/Y H:i)
     * @return string
     */
    function format_datetime($datetime, $format = 'd/m/Y H:i')
    {
        if (empty($datetime) || $datetime === '0000-00-00 00:00:00') {
            return '-';
        }
        
        date_default_timezone_set('Asia/Jakarta');
        return date($format, strtotime($datetime));
    }
}

if (!function_exists('format_date')) {
    /**
     * Format date ke format Indonesia
     * @param string $date Date string
     * @param string $format Format output (default: d/m/Y)
     * @return string
     */
    function format_date($date, $format = 'd/m/Y')
    {
        if (empty($date) || $date === '0000-00-00') {
            return '-';
        }
        
        date_default_timezone_set('Asia/Jakarta');
        return date($format, strtotime($date));
    }
}

if (!function_exists('format_time')) {
    /**
     * Format time ke format Indonesia
     * @param string $time Time string
     * @param string $format Format output (default: H:i)
     * @return string
     */
    function format_time($time, $format = 'H:i')
    {
        if (empty($time)) {
            return '-';
        }
        
        date_default_timezone_set('Asia/Jakarta');
        return date($format, strtotime($time));
    }
}

if (!function_exists('time_ago')) {
    /**
     * Menghitung waktu yang lalu (time ago)
     * @param string $datetime Datetime string
     * @return string
     */
    function time_ago($datetime)
    {
        if (empty($datetime) || $datetime === '0000-00-00 00:00:00') {
            return '-';
        }
        
        date_default_timezone_set('Asia/Jakarta');
        $time = time() - strtotime($datetime);
        
        if ($time < 60) {
            return 'baru saja';
        } elseif ($time < 3600) {
            $minutes = floor($time / 60);
            return $minutes . ' menit yang lalu';
        } elseif ($time < 86400) {
            $hours = floor($time / 3600);
            return $hours . ' jam yang lalu';
        } elseif ($time < 2592000) {
            $days = floor($time / 86400);
            return $days . ' hari yang lalu';
        } elseif ($time < 31536000) {
            $months = floor($time / 2592000);
            return $months . ' bulan yang lalu';
        } else {
            $years = floor($time / 31536000);
            return $years . ' tahun yang lalu';
        }
    }
}

if (!function_exists('is_today')) {
    /**
     * Cek apakah tanggal adalah hari ini
     * @param string $date Date string
     * @return bool
     */
    function is_today($date)
    {
        if (empty($date)) {
            return false;
        }
        
        date_default_timezone_set('Asia/Jakarta');
        return date('Y-m-d', strtotime($date)) === date('Y-m-d');
    }
}

if (!function_exists('is_yesterday')) {
    /**
     * Cek apakah tanggal adalah kemarin
     * @param string $date Date string
     * @return bool
     */
    function is_yesterday($date)
    {
        if (empty($date)) {
            return false;
        }
        
        date_default_timezone_set('Asia/Jakarta');
        return date('Y-m-d', strtotime($date)) === date('Y-m-d', strtotime('-1 day'));
    }
}

if (!function_exists('get_indonesian_day')) {
    /**
     * Mendapatkan nama hari dalam bahasa Indonesia
     * @param string $date Date string
     * @return string
     */
    function get_indonesian_day($date)
    {
        if (empty($date)) {
            return '-';
        }
        
        date_default_timezone_set('Asia/Jakarta');
        $days = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
        
        $day = date('l', strtotime($date));
        return $days[$day] ?? '-';
    }
}

if (!function_exists('get_indonesian_month')) {
    /**
     * Mendapatkan nama bulan dalam bahasa Indonesia
     * @param string $date Date string
     * @return string
     */
    function get_indonesian_month($date)
    {
        if (empty($date)) {
            return '-';
        }
        
        date_default_timezone_set('Asia/Jakarta');
        $months = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];
        
        $month = date('F', strtotime($date));
        return $months[$month] ?? '-';
    }
}

if (!function_exists('format_datetime_indonesian')) {
    /**
     * Format datetime ke format Indonesia lengkap
     * @param string $datetime Datetime string
     * @return string
     */
    function format_datetime_indonesian($datetime)
    {
        if (empty($datetime) || $datetime === '0000-00-00 00:00:00') {
            return '-';
        }
        
        date_default_timezone_set('Asia/Jakarta');
        $day = get_indonesian_day($datetime);
        $date = date('d', strtotime($datetime));
        $month = get_indonesian_month($datetime);
        $year = date('Y', strtotime($datetime));
        $time = date('H:i', strtotime($datetime));
        
        return $day . ', ' . $date . ' ' . $month . ' ' . $year . ' ' . $time;
    }
}

if (!function_exists('get_order_status_badge')) {
    /**
     * Mendapatkan badge untuk status pesanan
     * @param string $status Status pesanan
     * @return string
     */
    function get_order_status_badge($status)
    {
        $badges = [
            'pending' => '<span class="badge badge-warning">Menunggu</span>',
            'processing' => '<span class="badge badge-info">Diproses</span>',
            'completed' => '<span class="badge badge-success">Selesai</span>',
            'cancelled' => '<span class="badge badge-danger">Dibatalkan</span>'
        ];
        
        return $badges[$status] ?? '<span class="badge badge-secondary">' . ucfirst($status) . '</span>';
    }
}

if (!function_exists('get_payment_status_badge')) {
    /**
     * Mendapatkan badge untuk status pembayaran
     * @param string $status Status pembayaran
     * @return string
     */
    function get_payment_status_badge($status)
    {
        $badges = [
            'pending' => '<span class="badge badge-warning">Menunggu</span>',
            'paid' => '<span class="badge badge-success">Lunas</span>',
            'failed' => '<span class="badge badge-danger">Gagal</span>',
            'refunded' => '<span class="badge badge-info">Refund</span>'
        ];
        
        return $badges[$status] ?? '<span class="badge badge-secondary">' . ucfirst($status) . '</span>';
    }
}

if (!function_exists('calculate_estimated_time')) {
    /**
     * Menghitung estimasi waktu pesanan
     * @param string $created_at Waktu pesanan dibuat
     * @param int $estimated_minutes Estimasi dalam menit
     * @return string
     */
    function calculate_estimated_time($created_at, $estimated_minutes = 30)
    {
        if (empty($created_at)) {
            return '-';
        }
        
        date_default_timezone_set('Asia/Jakarta');
        $estimated_time = strtotime($created_at) + ($estimated_minutes * 60);
        $now = time();
        
        if ($estimated_time <= $now) {
            return 'Siap diambil';
        }
        
        $remaining_minutes = ceil(($estimated_time - $now) / 60);
        return $remaining_minutes . ' menit lagi';
    }
}
