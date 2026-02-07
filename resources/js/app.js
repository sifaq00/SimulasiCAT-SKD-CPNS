import './bootstrap';

// Timer function for simulation pages - must be global
window.timer = function(seconds) {
    return {
        totalSeconds: seconds,
        interval: null,
        
        init() {
            this.startTimer();
        },
        
        get minutes() {
            return Math.floor(this.totalSeconds / 60);
        },
        
        get seconds() {
            return this.totalSeconds % 60;
        },
        
        get display() {
            return `${String(this.minutes).padStart(2, '0')}:${String(this.seconds).padStart(2, '0')}`;
        },
        
        startTimer() {
            this.interval = setInterval(() => {
                if (this.totalSeconds > 0) {
                    this.totalSeconds--;
                } else {
                    this.stopTimer();
                    // Trigger Livewire event when timer expires
                    if (window.Livewire) {
                        Livewire.dispatch('timeExpired');
                    }
                }
            }, 1000);
        },
        
        stopTimer() {
            if (this.interval) {
                clearInterval(this.interval);
            }
        }
    };
};
