// Birthday Countdown Calculator
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('birthdayForm');
    const inputSection = document.getElementById('inputSection');
    const countdownSection = document.getElementById('countdownSection');
    const resetBtn = document.getElementById('resetBtn');
    
    let birthDate = null;
    let countdownInterval = null;

    // Zodiac signs data
    const zodiacSigns = [
        { name: 'Capricorn', start: [12, 22], end: [1, 19], dates: 'Dec 22 - Jan 19' },
        { name: 'Aquarius', start: [1, 20], end: [2, 18], dates: 'Jan 20 - Feb 18' },
        { name: 'Pisces', start: [2, 19], end: [3, 20], dates: 'Feb 19 - Mar 20' },
        { name: 'Aries', start: [3, 21], end: [4, 19], dates: 'Mar 21 - Apr 19' },
        { name: 'Taurus', start: [4, 20], end: [5, 20], dates: 'Apr 20 - May 20' },
        { name: 'Gemini', start: [5, 21], end: [6, 20], dates: 'May 21 - Jun 20' },
        { name: 'Cancer', start: [6, 21], end: [7, 22], dates: 'Jun 21 - Jul 22' },
        { name: 'Leo', start: [7, 23], end: [8, 22], dates: 'Jul 23 - Aug 22' },
        { name: 'Virgo', start: [8, 23], end: [9, 22], dates: 'Aug 23 - Sep 22' },
        { name: 'Libra', start: [9, 23], end: [10, 22], dates: 'Sep 23 - Oct 22' },
        { name: 'Scorpio', start: [10, 23], end: [11, 21], dates: 'Oct 23 - Nov 21' },
        { name: 'Sagittarius', start: [11, 22], end: [12, 21], dates: 'Nov 22 - Dec 21' }
    ];

    // Day names
    const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 
                       'July', 'August', 'September', 'October', 'November', 'December'];

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const day = parseInt(document.getElementById('day').value);
        const month = parseInt(document.getElementById('month').value);
        const year = parseInt(document.getElementById('year').value);
        const name = document.getElementById('name').value;

        // Validate date
        birthDate = new Date(year, month - 1, day);
        
        if (birthDate.getDate() !== day || birthDate.getMonth() !== month - 1) {
            alert('Please enter a valid date');
            return;
        }

        if (birthDate > new Date()) {
            alert('Birth date cannot be in the future');
            return;
        }

        // Show countdown section
        inputSection.classList.add('hidden');
        countdownSection.classList.remove('hidden');

        // Set greeting
        const greeting = name ? `Hello, ${name}!` : 'Hello!';
        document.getElementById('greeting').textContent = greeting;

        // Calculate and display all information
        calculateBirthdayInfo();
        startCountdown();
    });

    // Reset button
    resetBtn.addEventListener('click', function() {
        if (countdownInterval) {
            clearInterval(countdownInterval);
        }
        birthDate = null;
        form.reset();
        inputSection.classList.remove('hidden');
        countdownSection.classList.add('hidden');
    });

    function getZodiacSign(month, day) {
        for (let sign of zodiacSigns) {
            const [startMonth, startDay] = sign.start;
            const [endMonth, endDay] = sign.end;
            
            if (startMonth === endMonth) {
                if (month === startMonth && day >= startDay && day <= endDay) {
                    return sign;
                }
            } else {
                if ((month === startMonth && day >= startDay) || 
                    (month === endMonth && day <= endDay)) {
                    return sign;
                }
            }
        }
        return zodiacSigns[0];
    }

    function getNextBirthday(birthDate) {
        const now = new Date();
        const currentYear = now.getFullYear();
        
        let nextBirthday = new Date(currentYear, birthDate.getMonth(), birthDate.getDate());
        
        if (nextBirthday < now) {
            nextBirthday = new Date(currentYear + 1, birthDate.getMonth(), birthDate.getDate());
        }
        
        return nextBirthday;
    }

    function getLastBirthday(birthDate) {
        const now = new Date();
        const currentYear = now.getFullYear();
        
        let lastBirthday = new Date(currentYear, birthDate.getMonth(), birthDate.getDate());
        
        if (lastBirthday > now) {
            lastBirthday = new Date(currentYear - 1, birthDate.getMonth(), birthDate.getDate());
        }
        
        return lastBirthday;
    }

    function getNextMilestone(birthDate) {
        const age = Math.floor((new Date() - birthDate) / (365.25 * 24 * 60 * 60 * 1000));
        const milestones = [10, 13, 16, 18, 21, 25, 30, 40, 50, 60, 70, 75, 80, 90, 100];
        
        for (let milestone of milestones) {
            if (age < milestone) {
                const milestoneYear = birthDate.getFullYear() + milestone;
                const milestoneDate = new Date(milestoneYear, birthDate.getMonth(), birthDate.getDate());
                return { age: milestone, date: milestoneDate };
            }
        }
        
        return { age: 100, date: new Date(birthDate.getFullYear() + 100, birthDate.getMonth(), birthDate.getDate()) };
    }

    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    function calculateBirthdayInfo() {
        const now = new Date();
        const nextBirthday = getNextBirthday(birthDate);
        const lastBirthday = getLastBirthday(birthDate);
        
        // Calculate age
        let age = now.getFullYear() - birthDate.getFullYear();
        const monthDiff = now.getMonth() - birthDate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && now.getDate() < birthDate.getDate())) {
            age--;
        }

        // Current age
        document.getElementById('currentAge').textContent = age;
        
        // Exact age
        const years = age;
        const months = monthDiff >= 0 ? monthDiff : 12 + monthDiff;
        const days = now.getDate() >= birthDate.getDate() ? 
            now.getDate() - birthDate.getDate() : 
            new Date(now.getFullYear(), now.getMonth(), 0).getDate() - birthDate.getDate() + now.getDate();
        document.getElementById('exactAge').textContent = `${years} years, ${months} months, ${days} days`;

        // Days lived
        const daysLived = Math.floor((now - birthDate) / (1000 * 60 * 60 * 24));
        document.getElementById('daysLived').textContent = formatNumber(daysLived);
        
        const hoursLived = daysLived * 24;
        document.getElementById('hoursLived').textContent = formatNumber(hoursLived);

        // Day born
        const dayBorn = dayNames[birthDate.getDay()];
        document.getElementById('dayBorn').textContent = dayBorn;
        document.getElementById('dateFormatted').textContent = 
            `${monthNames[birthDate.getMonth()]} ${birthDate.getDate()}, ${birthDate.getFullYear()}`;

        // Zodiac sign
        const zodiac = getZodiacSign(birthDate.getMonth() + 1, birthDate.getDate());
        document.getElementById('zodiacSign').textContent = zodiac.name;
        document.getElementById('zodiacDates').textContent = zodiac.dates;

        // Next milestone
        const milestone = getNextMilestone(birthDate);
        document.getElementById('nextMilestone').textContent = `${milestone.age} Years`;
        document.getElementById('milestoneDate').textContent = 
            `${monthNames[milestone.date.getMonth()]} ${milestone.date.getDate()}, ${milestone.date.getFullYear()}`;

        // Life progress (assuming 80 years)
        const lifeProgress = Math.min((age / 80) * 100, 100).toFixed(1);
        document.getElementById('lifeProgress').textContent = `${lifeProgress}%`;
        document.getElementById('lifeProgressBar').style.width = `${lifeProgress}%`;

        // Weeks lived
        const weeksLived = Math.floor(daysLived / 7);
        document.getElementById('weeksLived').textContent = formatNumber(weeksLived);

        // Minutes lived
        const minutesLived = daysLived * 24 * 60;
        document.getElementById('minutesLived').textContent = formatNumber(minutesLived);

        // Heartbeats (average 70 bpm)
        const heartbeats = minutesLived * 70;
        document.getElementById('heartbeats').textContent = formatNumber(Math.floor(heartbeats / 1000000)) + 'M';

        // Breaths (average 15 per minute)
        const breaths = minutesLived * 15;
        document.getElementById('breaths').textContent = formatNumber(Math.floor(breaths / 1000000)) + 'M';

        // Age in different units
        const ageInSeconds = Math.floor((now - birthDate) / 1000);
        const ageInMinutes = Math.floor(ageInSeconds / 60);
        const ageInHours = Math.floor(ageInMinutes / 60);
        const ageInDays = Math.floor(ageInHours / 24);
        const ageInWeeks = Math.floor(ageInDays / 7);
        const ageInMonths = years * 12 + months;

        document.getElementById('ageInMonths').textContent = formatNumber(ageInMonths);
        document.getElementById('ageInWeeks').textContent = formatNumber(ageInWeeks);
        document.getElementById('ageInDays').textContent = formatNumber(ageInDays);
        document.getElementById('ageInHours').textContent = formatNumber(ageInHours);
        document.getElementById('ageInSeconds').textContent = formatNumber(ageInSeconds);

        // Last birthday
        document.getElementById('lastBirthday').textContent = 
            `${monthNames[lastBirthday.getMonth()]} ${lastBirthday.getDate()}, ${lastBirthday.getFullYear()}`;
        document.getElementById('lastBirthdayDay').textContent = dayNames[lastBirthday.getDay()];

        // Next birthday
        document.getElementById('upcomingBirthday').textContent = 
            `${monthNames[nextBirthday.getMonth()]} ${nextBirthday.getDate()}, ${nextBirthday.getFullYear()}`;
        document.getElementById('upcomingBirthdayDay').textContent = dayNames[nextBirthday.getDay()];

        // Next birthday text
        const nextAge = age + 1;
        document.getElementById('nextBirthday').textContent = 
            `Your next birthday is on ${dayNames[nextBirthday.getDay()]}, ${monthNames[nextBirthday.getMonth()]} ${nextBirthday.getDate()}, ${nextBirthday.getFullYear()} - You'll turn ${nextAge}!`;
    }

    function startCountdown() {
        function updateCountdown() {
            const now = new Date();
            const nextBirthday = getNextBirthday(birthDate);
            const diff = nextBirthday - now;

            if (diff <= 0) {
                // It's the birthday!
                clearInterval(countdownInterval);
                document.getElementById('greeting').textContent = '🎉 HAPPY BIRTHDAY! 🎉';
                return;
            }

            // Calculate time units
            const seconds = Math.floor(diff / 1000);
            const minutes = Math.floor(seconds / 60);
            const hours = Math.floor(minutes / 60);
            const days = Math.floor(hours / 24);
            const weeks = Math.floor(days / 7);
            const months = Math.floor(days / 30.44); // Average days in a month
            const years = Math.floor(days / 365.25);

            // Display countdown
            document.getElementById('years').textContent = years;
            document.getElementById('months').textContent = months % 12;
            document.getElementById('days').textContent = days % 30;
            document.getElementById('hours').textContent = hours % 24;
            document.getElementById('minutes').textContent = minutes % 60;
            document.getElementById('seconds').textContent = seconds % 60;

            // Calculate progress through the year
            const lastBirthday = getLastBirthday(birthDate);
            const yearDuration = nextBirthday - lastBirthday;
            const yearProgress = ((now - lastBirthday) / yearDuration) * 100;
            
            document.getElementById('progressPercent').textContent = `${yearProgress.toFixed(1)}%`;
            document.getElementById('progressBar').style.width = `${yearProgress}%`;
        }

        updateCountdown();
        countdownInterval = setInterval(updateCountdown, 1000);
    }
});



