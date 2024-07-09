document.addEventListener("DOMContentLoaded", function() {
    const fixturesList = document.getElementById("fixtures-list");
    const countdownTimer = document.getElementById("countdown-timer");
    const corsProxy = "https://corsproxy.io/?"; // Public CORS proxy

    const bootstrapUrl = corsProxy + encodeURIComponent("https://fantasy.premierleague.com/api/bootstrap-static/");
    const fixturesUrl = corsProxy + encodeURIComponent("https://fantasy.premierleague.com/api/fixtures/");

    // Fetch current gameweek data
    fetch(bootstrapUrl)
        .then(response => response.json())
        .then(data => {
            let currentGameweekId = data.events.find(event => event.is_current)?.id;

            if (currentGameweekId) {
                const nextGameweekId = currentGameweekId + 1;

                // Fetch fixtures for the next gameweek
                fetch(fixturesUrl)
                    .then(response => response.json())
                    .then(fixtures => {
                        const nextGameweekFixtures = fixtures.filter(fixture => fixture.event === nextGameweekId);

                        // Sort fixtures by kickoff time to get the earliest one
                        nextGameweekFixtures.sort((a, b) => new Date(a.kickoff_time) - new Date(b.kickoff_time));

                        if (nextGameweekFixtures.length > 0) {
                            const firstFixture = nextGameweekFixtures[0];
                            const kickoffTime = new Date(firstFixture.kickoff_time);

                            // Set countdown timer
                            setCountdown(kickoffTime);

                            // Display fixtures
                            fixturesList.innerHTML = '';
                            nextGameweekFixtures.forEach(fixture => {
                                const fixtureItem = document.createElement("div");
                                const homeTeam = data.teams.find(team => team.id === fixture.team_h);
                                const awayTeam = data.teams.find(team => team.id === fixture.team_a);
                                if (homeTeam && awayTeam) {
                                    const fixtureKickoffTime = new Date(fixture.kickoff_time).toLocaleString();
                                    fixtureItem.textContent = `${homeTeam.name} vs ${awayTeam.name} (${fixtureKickoffTime})`;
                                    fixturesList.appendChild(fixtureItem);
                                }
                            });
                        } else {
                            fixturesList.innerHTML = '<p>No fixtures found for the next gameweek. Please disable your adblocker or visit the <a href="https://fantasy.premierleague.com/fixtures" target="_blank">official fixtures page</a>.</p>';
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching fixtures:", error);
                        fixturesList.innerHTML = '<p>Unable to load fixtures. Please disable your adblocker or visit the <a href="https://fantasy.premierleague.com/fixtures" target="_blank">official fixtures page</a>.</p>';
                    });
            } else {
                fixturesList.innerHTML = '<p>No current gameweek found. Please disable your adblocker or visit the <a href="https://fantasy.premierleague.com/fixtures" target="_blank">official fixtures page</a>.</p>';
            }
        })
        .catch(error => {
            console.error("Error fetching bootstrap data:", error);
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

            countdownTimer.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;

            if (distance < 0) {
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
