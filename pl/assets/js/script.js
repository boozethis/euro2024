document.addEventListener("DOMContentLoaded", function() {
    const fixturesList = document.getElementById("fixtures-list");
    const corsProxy = "https://corsproxy.io/?"; // Public CORS proxy

    const bootstrapUrl = corsProxy + encodeURIComponent("https://fantasy.premierleague.com/api/bootstrap-static/");

    fetch(bootstrapUrl)
        .then(response => {
            console.log("Fetched bootstrap-static data", response);
            return response.json();
        })
        .then(data => {
            console.log("Parsed bootstrap-static data", data);
            let currentGameweekId;
            let nextGameweekId;
            for (const event of data.events) {
                if (event.is_current) {
                    currentGameweekId = event.id;
                }
                if (event.is_next) {
                    nextGameweekId = event.id;
                }
            }
            console.log("Current gameweek ID", currentGameweekId);
            console.log("Next gameweek ID", nextGameweekId);
            
            const gameweekId = currentGameweekId || nextGameweekId;
            if (gameweekId) {
                const fixturesUrl = corsProxy + encodeURIComponent(`https://fantasy.premierleague.com/api/fixtures/?event=${gameweekId}`);
                fetch(fixturesUrl)
                    .then(response => {
                        console.log("Fetched fixtures data", response);
                        return response.json();
                    })
                    .then(fixtures => {
                        console.log("Parsed fixtures data", fixtures);
                        fixturesList.innerHTML = ''; // Clear fallback content
                        fixtures.forEach(fixture => {
                            const fixtureItem = document.createElement("div");
                            const homeTeam = data.teams.find(team => team.id === fixture.team_h);
                            const awayTeam = data.teams.find(team => team.id === fixture.team_a);
                            if (homeTeam && awayTeam) {
                                const kickoffTime = new Date(fixture.kickoff_time).toLocaleString();
                                fixtureItem.textContent = `${homeTeam.name} vs ${awayTeam.name} (${kickoffTime})`;
                                fixturesList.appendChild(fixtureItem);
                            } else {
                                console.warn("Home or away team not found", fixture);
                            }
                        });
                    })
                    .catch(error => {
                        console.error("Error fetching fixtures:", error);
                        fixturesList.innerHTML = '<p>Unable to load fixtures. If you are unable to see the fixtures, please disable your adblocker or visit the <a href="https://fantasy.premierleague.com/fixtures" target="_blank">official fixtures page</a>.</p>';
                    });
            } else {
                fixturesList.innerHTML = '<p>No upcoming fixtures found. If you are unable to see the fixtures, please disable your adblocker or visit the <a href="https://fantasy.premierleague.com/fixtures" target="_blank">official fixtures page</a>.</p>';
            }
        })
        .catch(error => {
            console.error("Error fetching bootstrap data:", error);
            fixturesList.innerHTML = '<p>Unable to load fixtures. If you are unable to see the fixtures, please disable your adblocker or visit the <a href="https://fantasy.premierleague.com/fixtures" target="_blank">official fixtures page</a>.</p>';
        });

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
