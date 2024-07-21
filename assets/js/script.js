document.addEventListener("DOMContentLoaded", function() {
    const fixturesList = document.getElementById("fixtures-list");
    const countdownTimer = document.getElementById("countdown-timer");
    const corsProxy = "https://api.allorigins.win/get?url=";

    const fixturesUrl = corsProxy + encodeURIComponent("https://lastmanballing.com/fixtures.json");

    fetch(fixturesUrl)
        .then(response => response.json())
        .then(data => {
            const content = JSON.parse(data.contents); // Parse the JSON from the contents
            const currentDate = new Date();
            let currentGameweek = null;

            // Find the current gameweek based on the current date
            for (let i = 0; i < content.gameweeks.length; i++) {
                const gameweek = content.gameweeks[i];
                const startDate = new Date(gameweek.start_date);
                const endDate = new Date(gameweek.end_date);

                if (currentDate >= startDate && currentDate <= endDate) {
                    currentGameweek = gameweek;
                    break;
                }
            }

            if (currentGameweek) {
                const fixtures = currentGameweek.fixtures;
                const gameweekNumber = currentGameweek.gameweek;

                // Update header with gameweek number
                const fixturesHeader = document.querySelector("#fixtures h2");
                if (fixturesHeader) {
                    fixturesHeader.textContent = `Gameweek ${gameweekNumber} Fixtures`;
                }

                // Display fixtures
                fixturesList.innerHTML = '';
                fixtures.forEach(fixture => {
                    const fixtureItem = document.createElement("div");
                    fixtureItem.textContent = `${fixture.home} vs ${fixture.away}`;
                    fixturesList.appendChild(fixtureItem);
                });

                // Set countdown timer to the kickoff of the first fixture of the gameweek
                const firstFixtureDate = new Date(currentGameweek.fixtures[0].kickoff_time);
                setCountdown(firstFixtureDate);
            } else {
                fixturesList.innerHTML = '<p>No fixtures found for the current gameweek. Please check back later.</p>';
            }
        })
        .catch(error => {
            console.error("Error fetching fixtures:", error);
            fixturesList.innerHTML = '<p>Unable to load fixtures. Please check back later.</p>';
        });

    function setCountdown(kickoffTime) {
        function updateCountdown() {
            const now = new Date().getTime();
            const distance = kickoffTime - now;

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            if (distance >= 0) {
                countdownTimer.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            } else {
                countdownTimer.textContent = "EXPIRED";
            }
        }

        updateCountdown(); // Initial call to set the countdown immediately
        setInterval(updateCountdown, 1000); // Update every second
    }

    // FAQ toggle
    const faqItems = document.querySelectorAll(".faq-item h3");
    faqItems.forEach(item => {
        item.addEventListener("click", () => {
            const answer = item.nextElementSibling;
            if (answer.style.display === "block") {
                answer.style.display = "none";
            } else {
                document.querySelectorAll(".faq-content").forEach(content => {
                    content.style.display = "none";
                });
                answer.style.display = "block";
            }
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
