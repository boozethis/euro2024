document.addEventListener("DOMContentLoaded", function() {
    const fixturesList = document.getElementById("fixtures-list");
    const fixturesHeader = document.getElementById("fixtures-header");
    const countdownTimer = document.getElementById("countdown-timer");
    const fixturesUrl = "fixtures.json"; // Ensure this path is correct

    // Fetch fixtures data from the JSON file
    fetch(fixturesUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const gameweeks = data.gameweeks;
            const currentDate = new Date();
            
            // Find the current gameweek based on the date
            const currentGameweek = gameweeks.find(gameweek => {
                const startDate = new Date(gameweek.start_date);
                const endDate = new Date(gameweek.end_date);
                return currentDate >= startDate && currentDate <= endDate;
            });

            if (currentGameweek) {
                console.log(`Current Gameweek ID: ${currentGameweek.gameweek}`);
                console.log(`First fixture kickoff time: ${currentGameweek.start_date}`);

                // Update the header with the current gameweek number
                fixturesHeader.textContent = `Gameweek ${currentGameweek.gameweek} Fixtures`;

                // Display the fixtures for the current gameweek
                fixturesList.innerHTML = '';
                currentGameweek.fixtures.forEach(fixture => {
                    const fixtureItem = document.createElement("div");
                    fixtureItem.textContent = `${fixture.home} vs ${fixture.away}`;
                    fixturesList.appendChild(fixtureItem);
                });

                // Set countdown timer to the first fixture of the current gameweek
                const firstFixtureDate = new Date(currentGameweek.start_date);
                setCountdown(firstFixtureDate);
            } else {
                fixturesHeader.textContent = 'Weekly Fixtures';
                fixturesList.innerHTML = '<p>No fixtures found for the current gameweek. Please disable your adblocker or visit the <a href="https://fantasy.premierleague.com/fixtures" target="_blank">official fixtures page</a>.</p>';
            }
        })
        .catch(error => {
            console.error("Error fetching fixtures:", error);
            fixturesHeader.textContent = 'Weekly Fixtures';
            fixturesList.innerHTML = '<p>Unable to load fixtures. Please disable your adblocker or visit the <a href="https://fantasy.premierleague.com/fixtures" target="_blank">official fixtures page</a>.</p>';
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
