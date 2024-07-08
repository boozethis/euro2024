document.addEventListener("DOMContentLoaded", function() {
    const fixturesList = document.getElementById("fixtures-list");
    const corsProxy = "https://corsproxy.io/?"; // Public CORS proxy

    const bootstrapUrl = corsProxy + encodeURIComponent("https://fantasy.premierleague.com/api/bootstrap-static/");

    // Use async/await for cleaner asynchronous code
    async function fetchData(url) {
        try {
            const response = await fetch(url);
            if (!response.ok) throw new Error('Network response was not ok');
            return await response.json();
        } catch (error) {
            console.error('Error fetching data:', error);
            return null;
        }
    }

    async function loadFixtures() {
        const data = await fetchData(bootstrapUrl);
        if (!data) {
            fixturesList.innerHTML = '<p>Unable to load fixtures. If you are unable to see the fixtures, please disable your adblocker or visit the <a href="https://fantasy.premierleague.com/fixtures" target="_blank">official fixtures page</a>.</p>';
            return;
        }

        let currentGameweekId;
        for (const event of data.events) {
            if (event.is_current) {
                currentGameweekId = event.id;
                break;
            }
        }

        if (!currentGameweekId) {
            fixturesList.innerHTML = '<p>No current gameweek found. If you are unable to see the fixtures, please disable your adblocker or visit the <a href="https://fantasy.premierleague.com/fixtures" target="_blank">official fixtures page</a>.</p>';
            return;
        }

        const fixturesUrl = corsProxy + encodeURIComponent(`https://fantasy.premierleague.com/api/fixtures/?event=${currentGameweekId}`);
        const fixtures = await fetchData(fixturesUrl);
        if (!fixtures) {
            fixturesList.innerHTML = '<p>Unable to load fixtures. If you are unable to see the fixtures, please disable your adblocker or visit the <a href="https://fantasy.premierleague.com/fixtures" target="_blank">official fixtures page</a>.</p>';
            return;
        }

        fixturesList.innerHTML = ''; // Clear fallback content
        fixtures.forEach(fixture => {
            const fixtureItem = document.createElement("div");
            const homeTeam = data.teams.find(team => team.id === fixture.team_h);
            const awayTeam = data.teams.find(team => team.id === fixture.team_a);
            if (homeTeam && awayTeam) {
                const kickoffTime = new Date(fixture.kickoff_time).toLocaleString();
                fixtureItem.textContent = `${homeTeam.name} vs ${awayTeam.name} (${kickoffTime})`;
                fixturesList.appendChild(fixtureItem);
            }
        });
    }

    loadFixtures();

    // Countdown timer
    const countdownTimer = document.getElementById("countdown-timer");
    const countdownDate = new Date("August 16, 2024 20:00:00").getTime();

    function updateCountdown() {
        const now = new Date().getTime();
        const distance = countdownDate - now;

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        countdownTimer.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;

        if (distance < 0) {
            countdownTimer.textContent = "EXPIRED";
        }
    }

    setInterval(updateCountdown, 1000);

    // FAQ toggle
    const faqItems = document.querySelectorAll(".faq-item h3");
    faqItems.forEach(item => {
        item.addEventListener("click", () => {
            const answer = item.nextElementSibling;
            answer.style.display = answer.style.display === "block" ? "none" : "block";
        });
    });

    // Active nav item
    const navItems = document.querySelectorAll(".nav-item");
    navItems.forEach(item => {
        item.addEventListener("click", () => {
            navItems.forEach(nav => nav.classList.remove("nav-item-active"));
            item.classList.add("nav-item-active");
        });
    });
});
