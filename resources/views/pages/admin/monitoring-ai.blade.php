<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-outfit font-bold text-2xl text-white leading-tight">
                Monitoring AI Usage
            </h2>
            <p class="text-sm text-gray-400 mt-1">Pantau penggunaan dan performa AI hari ini.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="glass-panel rounded-2xl border border-white/5">
            <div class="p-5 border-b border-white/5 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-500/20 flex items-center justify-center text-blue-400">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="font-outfit font-semibold text-lg text-white">Monitoring AI Usage</h3>
            </div>
            <div class="p-6 grid grid-cols-2 md:grid-cols-4 gap-6">
                <div>
                    <p class="text-xs text-purple-300/70 mb-1 font-medium uppercase tracking-wider">Total Request AI</p>
                    <p class="text-2xl font-bold font-outfit text-white">{{ $aiStats['total_requests'] }}</p>
                </div>
                <div>
                    <p class="text-xs text-red-400/70 mb-1 font-medium uppercase tracking-wider">Error AI</p>
                    <p class="text-2xl font-bold font-outfit text-white">{{ $aiStats['errors'] }}</p>
                </div>
                <div>
                    <p class="text-xs text-blue-300/70 mb-1 font-medium uppercase tracking-wider">Response Time</p>
                    <p class="text-2xl font-bold font-outfit text-white">{{ $aiStats['avg_response_time'] }}</p>
                </div>
                <div>
                    <p class="text-xs text-green-300/70 mb-1 font-medium uppercase tracking-wider">Usage per User</p>
                    <p class="text-2xl font-bold font-outfit text-white">{{ $aiStats['usage_per_user'] }}</p>
                </div>
            </div>
        </div>

        <div class="glass-panel p-6 rounded-2xl border border-white/5 bg-gradient-to-b from-gray-800/80 to-gray-900/80 mt-6">
            <h3 class="font-outfit font-bold text-xl text-white mb-2">Trend AI Requests</h3>
            <p class="text-sm text-gray-400 mb-6">Grafik 7 hari terakhir dari request AI yang tercatat di database.</p>
            <div class="mb-4 flex items-center justify-between rounded-xl border border-white/5 bg-white/5 px-4 py-3">
                <p class="text-sm text-gray-300">Total request 7 hari terakhir</p>
                <p class="font-outfit text-lg font-bold text-white">{{ $aiTrend['total_last_7_days'] }}</p>
            </div>
            <div class="w-full relative h-64">
                <canvas id="aiRequestsTrendChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('aiRequestsTrendChart');

            if (!ctx) {
                return;
            }

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($aiTrend['labels']),
                    datasets: [{
                        label: 'AI Requests',
                        data: @json($aiTrend['data']),
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2,
                        borderColor: 'rgba(96, 165, 250, 1)',
                        backgroundColor: 'rgba(59, 130, 246, 0.16)',
                        pointBackgroundColor: 'rgba(147, 197, 253, 1)',
                        pointBorderColor: 'rgba(15, 23, 42, 1)',
                        pointRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                color: 'rgba(255, 255, 255, 0.7)'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.08)'
                            }
                        },
                        x: {
                            ticks: {
                                color: 'rgba(255, 255, 255, 0.7)'
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: 'rgba(255, 255, 255, 0.9)'
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-admin-layout>
