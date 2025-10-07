<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Birthday Countdown Calculator</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900|space-mono:400,700" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/birthday.js'])
</head>
<body class="bg-white text-black min-h-screen font-sans antialiased">
    <!-- Header -->
    <header class="border-b border-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">BIRTHDAY COUNTDOWN</h1>
                <div class="flex items-center gap-4">
                    <button id="resetBtn" class="px-4 py-2 border border-black hover:bg-black hover:text-white transition-colors duration-200 text-sm font-medium">
                        RESET
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <!-- Input Section -->
        <div id="inputSection" class="max-w-2xl mx-auto mb-12">
            <div class="border-2 border-black p-8 sm:p-12">
                <h2 class="text-xl sm:text-2xl font-bold mb-6 text-center">ENTER YOUR BIRTH DATE</h2>
                
                <form id="birthdayForm" class="space-y-6">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="day" class="block text-xs font-bold mb-2 uppercase tracking-wider">Day</label>
                            <input type="number" id="day" min="1" max="31" 
                                   class="w-full px-4 py-3 border-2 border-black focus:outline-none focus:ring-2 focus:ring-black text-lg font-mono"
                                   placeholder="DD" required>
                        </div>
                        <div>
                            <label for="month" class="block text-xs font-bold mb-2 uppercase tracking-wider">Month</label>
                            <input type="number" id="month" min="1" max="12"
                                   class="w-full px-4 py-3 border-2 border-black focus:outline-none focus:ring-2 focus:ring-black text-lg font-mono"
                                   placeholder="MM" required>
                        </div>
                        <div>
                            <label for="year" class="block text-xs font-bold mb-2 uppercase tracking-wider">Year</label>
                            <input type="number" id="year" min="1900" max="2025"
                                   class="w-full px-4 py-3 border-2 border-black focus:outline-none focus:ring-2 focus:ring-black text-lg font-mono"
                                   placeholder="YYYY" required>
                        </div>
                    </div>

                    <div>
                        <label for="name" class="block text-xs font-bold mb-2 uppercase tracking-wider">Your Name (Optional)</label>
                        <input type="text" id="name" 
                               class="w-full px-4 py-3 border-2 border-black focus:outline-none focus:ring-2 focus:ring-black text-lg"
                               placeholder="Enter your name">
                    </div>

                    <button type="submit" 
                            class="w-full bg-black text-white py-4 px-6 text-lg font-bold hover:bg-gray-800 transition-colors duration-200 uppercase tracking-wider">
                        Calculate Countdown
                    </button>
                </form>
            </div>
        </div>

        <!-- Countdown Display Section -->
        <div id="countdownSection" class="hidden">
            <!-- Greeting -->
            <div class="text-center mb-12">
                <h2 id="greeting" class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4"></h2>
                <p id="nextBirthday" class="text-lg sm:text-xl text-gray-700"></p>
            </div>

            <!-- Main Countdown Timer -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-12">
                <div class="countdown-unit">
                    <div class="border-2 border-black p-6 text-center">
                        <div id="years" class="text-4xl sm:text-5xl font-bold font-mono mb-2">0</div>
                        <div class="text-xs font-bold uppercase tracking-wider">Years</div>
                    </div>
                </div>
                <div class="countdown-unit">
                    <div class="border-2 border-black p-6 text-center">
                        <div id="months" class="text-4xl sm:text-5xl font-bold font-mono mb-2">0</div>
                        <div class="text-xs font-bold uppercase tracking-wider">Months</div>
                    </div>
                </div>
                <div class="countdown-unit">
                    <div class="border-2 border-black p-6 text-center">
                        <div id="days" class="text-4xl sm:text-5xl font-bold font-mono mb-2">0</div>
                        <div class="text-xs font-bold uppercase tracking-wider">Days</div>
                    </div>
                </div>
                <div class="countdown-unit">
                    <div class="border-2 border-black p-6 text-center">
                        <div id="hours" class="text-4xl sm:text-5xl font-bold font-mono mb-2">0</div>
                        <div class="text-xs font-bold uppercase tracking-wider">Hours</div>
                    </div>
                </div>
                <div class="countdown-unit">
                    <div class="border-2 border-black p-6 text-center">
                        <div id="minutes" class="text-4xl sm:text-5xl font-bold font-mono mb-2">0</div>
                        <div class="text-xs font-bold uppercase tracking-wider">Minutes</div>
                    </div>
                </div>
                <div class="countdown-unit">
                    <div class="border-2 border-black p-6 text-center">
                        <div id="seconds" class="text-4xl sm:text-5xl font-bold font-mono mb-2">0</div>
                        <div class="text-xs font-bold uppercase tracking-wider">Seconds</div>
                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="mb-12">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider">Year Progress</span>
                    <span id="progressPercent" class="text-xs font-bold font-mono">0%</span>
                </div>
                <div class="w-full h-4 border-2 border-black">
                    <div id="progressBar" class="h-full bg-black transition-all duration-1000" style="width: 0%"></div>
                </div>
            </div>

            <!-- Statistics Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                <!-- Current Age -->
                <div class="border-2 border-black p-6">
                    <div class="text-xs font-bold uppercase tracking-wider mb-3 text-gray-600">Current Age</div>
                    <div id="currentAge" class="text-3xl font-bold font-mono mb-1">0</div>
                    <div id="exactAge" class="text-sm text-gray-600"></div>
                </div>

                <!-- Days Lived -->
                <div class="border-2 border-black p-6">
                    <div class="text-xs font-bold uppercase tracking-wider mb-3 text-gray-600">Days Lived</div>
                    <div id="daysLived" class="text-3xl font-bold font-mono mb-1">0</div>
                    <div class="text-sm text-gray-600">
                        <span id="hoursLived" class="font-mono"></span> hours
                    </div>
                </div>

                <!-- Day Born -->
                <div class="border-2 border-black p-6">
                    <div class="text-xs font-bold uppercase tracking-wider mb-3 text-gray-600">Born On</div>
                    <div id="dayBorn" class="text-2xl font-bold mb-1">-</div>
                    <div id="dateFormatted" class="text-sm text-gray-600"></div>
                </div>

                <!-- Zodiac Sign -->
                <div class="border-2 border-black p-6">
                    <div class="text-xs font-bold uppercase tracking-wider mb-3 text-gray-600">Zodiac Sign</div>
                    <div id="zodiacSign" class="text-2xl font-bold mb-1">-</div>
                    <div id="zodiacDates" class="text-sm text-gray-600"></div>
                </div>

                <!-- Next Milestone -->
                <div class="border-2 border-black p-6">
                    <div class="text-xs font-bold uppercase tracking-wider mb-3 text-gray-600">Next Milestone</div>
                    <div id="nextMilestone" class="text-2xl font-bold mb-1">-</div>
                    <div id="milestoneDate" class="text-sm text-gray-600"></div>
                </div>

                <!-- Life Progress -->
                <div class="border-2 border-black p-6">
                    <div class="text-xs font-bold uppercase tracking-wider mb-3 text-gray-600">Life Progress (80 years)</div>
                    <div id="lifeProgress" class="text-3xl font-bold font-mono mb-2">0%</div>
                    <div class="w-full h-2 border border-black mt-2">
                        <div id="lifeProgressBar" class="h-full bg-black" style="width: 0%"></div>
                    </div>
                </div>
            </div>

            <!-- Additional Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-12">
                <div class="border border-black p-4 text-center">
                    <div class="text-xs font-bold uppercase tracking-wider mb-2 text-gray-600">Weeks Lived</div>
                    <div id="weeksLived" class="text-2xl font-bold font-mono">0</div>
                </div>
                <div class="border border-black p-4 text-center">
                    <div class="text-xs font-bold uppercase tracking-wider mb-2 text-gray-600">Minutes Lived</div>
                    <div id="minutesLived" class="text-2xl font-bold font-mono">0</div>
                </div>
                <div class="border border-black p-4 text-center">
                    <div class="text-xs font-bold uppercase tracking-wider mb-2 text-gray-600">Heartbeats</div>
                    <div id="heartbeats" class="text-2xl font-bold font-mono">0</div>
                </div>
                <div class="border border-black p-4 text-center">
                    <div class="text-xs font-bold uppercase tracking-wider mb-2 text-gray-600">Breaths Taken</div>
                    <div id="breaths" class="text-2xl font-bold font-mono">0</div>
                </div>
            </div>

            <!-- Age in Different Time Units -->
            <div class="border-2 border-black p-8">
                <h3 class="text-xl font-bold mb-6 uppercase tracking-wider">Your Age In Different Time Units</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                    <div class="text-center">
                        <div id="ageInMonths" class="text-2xl font-bold font-mono mb-1">0</div>
                        <div class="text-xs uppercase tracking-wider text-gray-600">Months</div>
                    </div>
                    <div class="text-center">
                        <div id="ageInWeeks" class="text-2xl font-bold font-mono mb-1">0</div>
                        <div class="text-xs uppercase tracking-wider text-gray-600">Weeks</div>
                    </div>
                    <div class="text-center">
                        <div id="ageInDays" class="text-2xl font-bold font-mono mb-1">0</div>
                        <div class="text-xs uppercase tracking-wider text-gray-600">Days</div>
                    </div>
                    <div class="text-center">
                        <div id="ageInHours" class="text-2xl font-bold font-mono mb-1">0</div>
                        <div class="text-xs uppercase tracking-wider text-gray-600">Hours</div>
                    </div>
                    <div class="text-center">
                        <div id="ageInSeconds" class="text-2xl font-bold font-mono mb-1">0</div>
                        <div class="text-xs uppercase tracking-wider text-gray-600">Seconds</div>
                    </div>
                </div>
            </div>

            <!-- Birthday Celebrations -->
            <div class="mt-12 border-2 border-black p-8">
                <h3 class="text-xl font-bold mb-6 uppercase tracking-wider">Birthday Celebrations</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider mb-3 text-gray-600">Last Birthday</div>
                        <div id="lastBirthday" class="text-lg font-mono mb-2">-</div>
                        <div id="lastBirthdayDay" class="text-sm text-gray-600"></div>
                    </div>
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider mb-3 text-gray-600">Upcoming Birthday</div>
                        <div id="upcomingBirthday" class="text-lg font-mono mb-2">-</div>
                        <div id="upcomingBirthdayDay" class="text-sm text-gray-600"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-black mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-center text-sm text-gray-600">
                &copy; {{ date('Y') }} Birthday Countdown Calculator. Made with precision.
            </p>
        </div>
    </footer>
</body>
</html>



