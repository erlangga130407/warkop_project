/**
 * Realtime DateTime JavaScript untuk Warkop Abah
 * Menampilkan waktu realtime di halaman admin dan user
 */

class RealtimeDateTime {
    constructor() {
        this.timezone = 'Asia/Jakarta';
        this.updateInterval = 1000; // Update setiap 1 detik
        this.init();
    }

    init() {
        this.updateAllDateTimeElements();
        this.startRealtimeUpdate();
    }

    /**
     * Update semua elemen datetime di halaman
     */
    updateAllDateTimeElements() {
        // Update current time
        this.updateCurrentTime();
        
        // Update time ago elements
        this.updateTimeAgoElements();
        
        // Update order status times
        this.updateOrderStatusTimes();
    }

    /**
     * Update waktu saat ini
     */
    updateCurrentTime() {
        const currentTimeElements = document.querySelectorAll('.current-time');
        const now = new Date();
        const formattedTime = this.formatDateTime(now);
        
        currentTimeElements.forEach(element => {
            element.textContent = formattedTime;
        });
    }

    /**
     * Update elemen time ago
     */
    updateTimeAgoElements() {
        const timeAgoElements = document.querySelectorAll('.time-ago');
        
        timeAgoElements.forEach(element => {
            const datetime = element.getAttribute('data-datetime');
            if (datetime) {
                const timeAgo = this.calculateTimeAgo(datetime);
                element.textContent = timeAgo;
            }
        });
    }

    /**
     * Update waktu status pesanan
     */
    updateOrderStatusTimes() {
        const orderTimeElements = document.querySelectorAll('.order-time');
        
        orderTimeElements.forEach(element => {
            const orderTime = element.getAttribute('data-order-time');
            const status = element.getAttribute('data-status');
            
            if (orderTime && status) {
                const timeInfo = this.getOrderTimeInfo(orderTime, status);
                element.innerHTML = timeInfo;
            }
        });
    }

    /**
     * Format datetime ke format Indonesia
     */
    formatDateTime(date) {
        const options = {
            timeZone: this.timezone,
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        
        const indonesianDate = new Intl.DateTimeFormat('id-ID', options).format(date);
        return indonesianDate;
    }

    /**
     * Hitung time ago
     */
    calculateTimeAgo(datetime) {
        const now = new Date();
        const past = new Date(datetime);
        const diffInSeconds = Math.floor((now - past) / 1000);
        
        if (diffInSeconds < 60) {
            return 'baru saja';
        } else if (diffInSeconds < 3600) {
            const minutes = Math.floor(diffInSeconds / 60);
            return `${minutes} menit yang lalu`;
        } else if (diffInSeconds < 86400) {
            const hours = Math.floor(diffInSeconds / 3600);
            return `${hours} jam yang lalu`;
        } else if (diffInSeconds < 2592000) {
            const days = Math.floor(diffInSeconds / 86400);
            return `${days} hari yang lalu`;
        } else if (diffInSeconds < 31536000) {
            const months = Math.floor(diffInSeconds / 2592000);
            return `${months} bulan yang lalu`;
        } else {
            const years = Math.floor(diffInSeconds / 31536000);
            return `${years} tahun yang lalu`;
        }
    }

    /**
     * Dapatkan informasi waktu pesanan
     */
    getOrderTimeInfo(orderTime, status) {
        const now = new Date();
        const orderDate = new Date(orderTime);
        const diffInMinutes = Math.floor((now - orderDate) / (1000 * 60));
        
        let timeInfo = '';
        
        switch (status) {
            case 'pending':
                if (diffInMinutes < 5) {
                    timeInfo = `<span class="text-warning">Baru (${diffInMinutes} menit)</span>`;
                } else if (diffInMinutes < 30) {
                    timeInfo = `<span class="text-info">Menunggu (${diffInMinutes} menit)</span>`;
                } else {
                    timeInfo = `<span class="text-danger">Lama (${diffInMinutes} menit)</span>`;
                }
                break;
            case 'processing':
                timeInfo = `<span class="text-primary">Diproses (${diffInMinutes} menit)</span>`;
                break;
            case 'completed':
                timeInfo = `<span class="text-success">Selesai (${diffInMinutes} menit)</span>`;
                break;
            case 'cancelled':
                timeInfo = `<span class="text-danger">Dibatalkan (${diffInMinutes} menit)</span>`;
                break;
            default:
                timeInfo = `<span class="text-muted">${diffInMinutes} menit</span>`;
        }
        
        return timeInfo;
    }

    /**
     * Mulai update realtime
     */
    startRealtimeUpdate() {
        setInterval(() => {
            this.updateAllDateTimeElements();
        }, this.updateInterval);
    }

    /**
     * Format tanggal untuk input
     */
    formatDateForInput(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    /**
     * Format waktu untuk input
     */
    formatTimeForInput(date) {
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        return `${hours}:${minutes}`;
    }

    /**
     * Dapatkan estimasi waktu pesanan
     */
    getEstimatedTime(orderTime, estimatedMinutes = 30) {
        const orderDate = new Date(orderTime);
        const estimatedDate = new Date(orderDate.getTime() + (estimatedMinutes * 60 * 1000));
        const now = new Date();
        
        if (estimatedDate <= now) {
            return 'Siap diambil';
        }
        
        const remainingMinutes = Math.ceil((estimatedDate - now) / (1000 * 60));
        return `${remainingMinutes} menit lagi`;
    }
}

// Inisialisasi ketika DOM siap
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi RealtimeDateTime
    window.realtimeDateTime = new RealtimeDateTime();
    
    // Update waktu setiap detik
    setInterval(function() {
        if (window.realtimeDateTime) {
            window.realtimeDateTime.updateAllDateTimeElements();
        }
    }, 1000);
    
    // Update waktu saat halaman di-focus
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden && window.realtimeDateTime) {
            window.realtimeDateTime.updateAllDateTimeElements();
        }
    });
});

// Fungsi helper untuk digunakan di halaman lain
function updateDateTimeElements() {
    if (window.realtimeDateTime) {
        window.realtimeDateTime.updateAllDateTimeElements();
    }
}

function formatDateTimeForDisplay(datetime) {
    if (window.realtimeDateTime) {
        return window.realtimeDateTime.formatDateTime(new Date(datetime));
    }
    return datetime;
}

function getTimeAgo(datetime) {
    if (window.realtimeDateTime) {
        return window.realtimeDateTime.calculateTimeAgo(datetime);
    }
    return datetime;
}
