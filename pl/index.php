<!DOCTYPE HTML>
<!--
 _                ___  _                           
| |__   __ _ ____/ _ \| |_ ___  _ __ _ __ ___  ___ 
| '_ \ / _` |_  / (_) | __/ _ \| '__| '__/ _ \/ __|
| |_) | (_| |/ / \__, | || (_) | |  | | |  __/\__ \
|_.__/ \__,_/___|  /_/ \__\___/|_|  |_|  \___||___/
   
-->
<html>
	<head>
		<title>Last Man Balling</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-QCV3HMSYMS"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-QCV3HMSYMS');
</script>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header" class="alt">
						<span class="logo"><img src="images/logo.png" width="25%" alt="" /></span>
						<h1>Last Man Balling</h1>
						<p>Coming Soon<br>
						</p>
					</header>

				<!-- Nav -->
					<nav id="nav">
						<ul>
							<li><a href="#about" class="active">About</a></li>
							<li><a href="#fixtures">Countdown</a></li>
							<li><a href="#prize">Prizepot</a></li>
							<li><a href="#rules">Rules</a></li>
							<li><a href="#join">Join</a></li>
							<li><a href="#faq">FAQ</a></li>
							<li><a href="#waitlist">Waiting List</a></li>		
							<li><a href="#contact">Contact</a></li>							
						</ul>
					</nav>

				<!-- Main -->
					<div id="main">

						<!-- About -->
							<section id="about" class="main">
								<div class="spotlight">
									<div class="content">
										<header class="major">
											<h2>About</h2>
										</header>
										<p>Last Man Balling is the last man standing / premier league killer game you may
										or may not be familiar with, on a much larger scale. Anyone can pay £10 to join 
										 and be in with a chance to win the biggest prizepot for this kind of game. <br><br>
										The LMB team have ran a number of successful local games among friends and have 
										decided to take it to the next level and host a game for the whole world to participate.
										</p>
										<ul class="actions">
											<li><a href="#rules" class="button primary">Rules</a></li>
											<li><a href="#join" class="button primary">Join</a></li>
										</ul>
									</div>
									<span class="image"><img src="images/purple.png" alt="" /></span>
								</div>
							</section>

<!-- Countdown -->
<section id="fixtures" class="main special">
  <header class="major">
  <h2>Countdown</h2>
  <ul class="features">

  <?php
  define("API_BASE_URL", "https://fantasy.premierleague.com/api/");
  define("BSSTATIC", "bootstrap-static/");

  $url = API_BASE_URL . BSSTATIC;
  $json = file_get_contents($url, false, stream_context_create(array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false))));
  $result_bootstrap = json_decode($json,true);

  foreach ($result_bootstrap["events"] as $gw) {
    if ($gw["is_next"]) {
      $next_gw_info = array(
        "gw" => $gw["id"],
        "deadline" => $gw["deadline_time"]
      );
    }
  }
  echo "<p><b>Gameweek " . $next_gw_info["gw"] . " Fixtures</b><br>";

  $fixurl = API_BASE_URL . "fixtures/?event=" . $next_gw_info["gw"];
  $jsonfix = file_get_contents($fixurl, false, stream_context_create(array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false))));
  $fixresult = json_decode($jsonfix,true);
  foreach ($fixresult as $fixture) {
    $kickoff_time = Get_Local_Time($fixture['kickoff_time']);
    foreach($result_bootstrap['teams'] as $team) {
      if($fixture['team_h']==$team['id']) {$hometeam = $team['name'];}
      if($fixture['team_a']==$team['id']) {$awayteam = $team['name'];}
    }
  echo $hometeam . " vs " . $awayteam;
  echo "<br>";
  }
  echo "</p>";

  function Get_Local_Time($datetime) {
      $dt = new DateTime($datetime, new DateTimeZone('UTC'));
      $dt->setTimezone(new DateTimeZone('Europe/London'));
      return $dt->format('D d M, H:i');
  }
  ?>

</header>
  <header class="major"><script src="assets/js/countdown.js"></script>
  <a href="https://logwork.com/countdown-yyoi" class="countdown-timer" data-style="circles" data-timezone="Europe/London" data-textcolor="#37003c" data-date="2023-08-11 18:00" data-background="#00ff87" data-digitscolor="#37003c" data-unitscolor="#37003c">Gameweek <?php echo $next_gw_info["gw"] ?> Deadline</a><br></header>
  <h2>The deadline to submit your pick is: <?php echo Get_Local_Time($next_gw_info["deadline"]) ?></h2><br><br>
  <footer class="major">
    <ul class="actions special">
      <li><a href="https://forms.gle/kjTNGNECSx8pVg2eA" target="_blank" class="button primary">Submit Your Pick</a></li>
      <li><a href="#join" class="button primary">Join</a></li>
    </ul>
  </footer>
</section>
							
						<!-- Prizepot -->
							<section id="prize" class="main special">
								<header class="major">
									<h2>Prizepot</h2>
									<p>90% of all entry fees contribute to the overall prize that will be won by the Last Man Balling.<br>
									The more people who play, the bigger the Prizepot.</p>
								</header>
								<ul class="statistics">
									<li class="style3">
										<span class="icon solid fa-users"></span>
										<strong>4,096</strong> <b>Ballers</b>
									</li>
									<li class="style5">
										<span class="icon solid fa-dizzy"></span>
										<strong>2,048</strong> <b>Eliminated</b>
									</li>									
									<li class="style4">
										<span class="icon solid fa-laugh-beam"></span>
										<strong>2,048</strong> <b>Balling</b>
									</li>
									<li class="style2">
										<span class="icon solid fa-trophy"></span>
										<strong>£36,864</strong> <b>Prizepot</b>
									</li>
								</ul>
								<p class="major">Good luck to all remaining Ballers!</p>
								<footer class="major">
									<ul class="actions special">
										<li><a href="#join" class="button primary">Join</a></li>
										<li><a href="#header" class="button">Top of the Page</a></li>
									</ul>
								</footer>
							</section>

						<!-- Rules -->
							<section id="rules" class="main special">
								<header class="major">
									<h2>Rules</h2>
							<p>These are the rules to play Last Man Balling. For any questions, please refer to the <a href="#faq">FAQs</a> below.</p>
							<section>
									<p>💷 Pay £10 to join Last Man Balling. You will be asked to provide a name (ideally your Twitter username) and an email address during the checkout process. You will be provided with a secret Personal Identification Number (PIN) with your payment confirmation.</p>
<p></p>
<p>🍯 The entry fees will contribute to the overall prize (or ‘Prizepot’) for winning the game. For the first game, 90% of entry fees will go into the prizepot and the remainder will go towards running costs such as hosting, promotional and administration fees. The more Ballers, the bigger the Prizepot.</p>
<p></p>
<p>🎯 Every week you must select a team that you think will win. To submit your prediction, you must complete an online form where you will enter your name, your PIN and the team you have chosen. All predictions must be submitted before the Gameweek deadline, which is 6PM every Friday.</p>
<p></p>
<p>🚫 You can only choose each team once. For example, if you chose Manchester City in a previous Gameweek, you cannot choose them again. If you submit a prediction for a team that you have already chosen, it will be treated as a failed submission.</p>
<p></p>
<p>🆎 If you have joined and fail to submit a selection before the deadline you will be assigned the first team that you haven’t already selected, alphabetically. For example, if you have already chosen Arsenal but haven’t used Aston Villa, you will be assigned Aston Villa.</p>
<p></p>
<p>✅ If your predicted team wins you survive and carry on Balling until the next week.</p>
<p></p>
<p>❌ If your predicted team draws or loses, you will lose a life.</p>
<p></p>
<p>3️⃣ Ballers start with three lives. Once your lives reach 0, your Balling days are over, and you are eliminated from the game.</p>
<p></p>
<p>🏆 The last remaining Baller, aka the Last Man Balling, wins the Prizepot. Winners will be contacted via email and/or social media to confirm payment details and will be paid within ten working days.</p>
<p></p>
<p>💀 If everyone is eliminated without a single Baller being left standing, there will be a rollover (or a ‘Ballover’). For example, if three Ballers remain going into a Gameweek, and they all end up losing their final life in the same set of fixtures, everyone is eliminated and a Ballover will occur.</p>
<p></p>
<p>🧻 In the event of a Ballover, Ballers wishing to re-join must pay a £10 entry fee again. All previous team predictions are reset and the prizepot will continue to build.</p>
<p></p>
<p>❓If you have any questions, please ask in the <a href="https://t.me/lastmanballing" target="_blank" rel="external">Telegram group</a>.</p>

								</header>
								<footer class="major">
									<ul class="actions special">
										<li><a href="#join" class="button primary">Join</a></li>
									</ul>
								</footer>
							</section>
							
														<!-- Join -->
							<section id="join" class="main special">
								<header class="major">
									<h2>How To Join</h2>
								</header>
								<ul class="features">
									<li>
										<a href="https://buy.stripe.com/fZe9E58bagsp16E3cc" target="_blank" rel="external"><span class="icon brands major style1 fa-cc-stripe"></span></a>
										<a href="https://buy.stripe.com/fZe9E58bagsp16E3cc" target="_blank" rel="external"><h3>Stripe</h3></a>
										<p>Use the button below to pay the £10 entry fee via our trusted payment provider, Stripe.</p>
									</li>
									<li>
										<a href="https://t.me/LastManBalling_bot" target="_blank" rel="external"><span class="icon brands major style4 fa-telegram"></span></a>
										<a href="https://t.me/LastManBalling_bot" target="_blank" rel="external"><h3>Telegram</h3></a>
										<p>You may also send a /join command to the <a href="https://t.me/LastManBalling_bot" target="_blank" rel="external">Last Man Balling Telegram Bot</a> to pay the £10 entry fee, also via Stripe.</p>
									</li>
								</ul>
								<footer class="major">
									<ul class="actions special">
										<li><a href="https://buy.stripe.com/fZe9E58bagsp16E3cc" target="_blank" rel="external" class="button primary">Pay £10 Entry Fee</a></li>
									</ul>
								</footer>
							</section>

					
					
																			<!-- FAQ -->
							<section id="faq" class="main special">
								<header class="major">
																	<h2>Frequently Asked Questions</h2>
							
							<section>
								<div class="dropdown">
  <div class="mx-auto max-w-prose px-2">
    <div class="accordion-item">
        <button type="button" class="accordion-header w-full flex justify-between items-center my-2 p-3 rounded" onclick="this.nextElementSibling.classList.toggle('max-h-0');this.nextElementSibling.classList.toggle('max-h-tall'); this.querySelector('.plus').classList.toggle('hidden'); this.querySelector('.minus').classList.toggle('hidden');">
          <p class="font-bold text-left" x-text="accordion.title">How do I join? </p>
          <svg xmlns="http://www.w3.org/2000/svg" class="plus h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" class="minus h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
          </svg>
        </button>
        <div class="accordion-content transition-maxheight ease-out duration-500 max-h-0 overflow-hidden mb-2">
          <p class="whitespace-pre-wrap" x-html="accordion.content">See the <a href="#join">Join</a> section above.</p>
        </div>
      </div><div class="accordion-item">
        <button type="button" class="accordion-header w-full flex justify-between items-center my-2 p-3 rounded" onclick="this.nextElementSibling.classList.toggle('max-h-0');this.nextElementSibling.classList.toggle('max-h-tall'); this.querySelector('.plus').classList.toggle('hidden'); this.querySelector('.minus').classList.toggle('hidden');">
          <p class="font-bold text-left" x-text="accordion.title">How can I pay? </p>
          <svg xmlns="http://www.w3.org/2000/svg" class="plus h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" class="minus h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
          </svg>
        </button>
        <div class="accordion-content transition-maxheight ease-out duration-500 max-h-0 overflow-hidden mb-2">
          <p class="whitespace-pre-wrap" x-html="accordion.content">Our secure payment provider, Stripe, accepts most payment types. <br>You can either pay directly by clicking the button in the <a href="#join">Join</a> section, or by visting the <a href="https://t.me/lastmanballing_bot" target="_blank" rel="external">Last Man Balling Bot</a> on telegram and sending the /join command.</p>
        </div>
      </div><div class="accordion-item">
        <button type="button" class="accordion-header w-full flex justify-between items-center my-2 p-3 rounded" onclick="this.nextElementSibling.classList.toggle('max-h-0');this.nextElementSibling.classList.toggle('max-h-tall'); this.querySelector('.plus').classList.toggle('hidden'); this.querySelector('.minus').classList.toggle('hidden');">
          <p class="font-bold text-left" x-text="accordion.title">When is the deadline to submit my selection?</p>
          <svg xmlns="http://www.w3.org/2000/svg" class="plus h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" class="minus h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
          </svg>
        </button>
        <div class="accordion-content transition-maxheight ease-out duration-500 max-h-0 overflow-hidden mb-2">
          <p class="whitespace-pre-wrap" x-html="accordion.content">Last Man Balling uses the weekend Premier League games, which sometimes include Friday and Monday games.<br> Therefore, the deadline for every week is approximately 6PM every Friday.</p>
        </div>
      </div><div class="accordion-item">
        <button type="button" class="accordion-header w-full flex justify-between items-center my-2 p-3 rounded" onclick="this.nextElementSibling.classList.toggle('max-h-0');this.nextElementSibling.classList.toggle('max-h-tall'); this.querySelector('.plus').classList.toggle('hidden'); this.querySelector('.minus').classList.toggle('hidden');">
          <p class="font-bold text-left" x-text="accordion.title">How do I submit my selection? </p>
          <svg xmlns="http://www.w3.org/2000/svg" class="plus h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" class="minus h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
          </svg>
        </button>
        <div class="accordion-content transition-maxheight ease-out duration-500 max-h-0 overflow-hidden mb-2">
          <p class="whitespace-pre-wrap" x-html="accordion.content">You must submit your weekly selection via [this Google Form] <br> Please include your name, your PIN and your prediction for the week.</p>
        </div>
      </div><div class="accordion-item">
        <button type="button" class="accordion-header w-full flex justify-between items-center my-2 p-3 rounded" onclick="this.nextElementSibling.classList.toggle('max-h-0');this.nextElementSibling.classList.toggle('max-h-tall'); this.querySelector('.plus').classList.toggle('hidden'); this.querySelector('.minus').classList.toggle('hidden');">
          <p class="font-bold text-left" x-text="accordion.title">Can I see which teams I have selected so far? </p>
          <svg xmlns="http://www.w3.org/2000/svg" class="plus h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" class="minus h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
          </svg>
        </button>
        <div class="accordion-content transition-maxheight ease-out duration-500 max-h-0 overflow-hidden mb-2">
          <p class="whitespace-pre-wrap" x-html="accordion.content">Yes, all selections so far can be viewed on [this Google Sheets document]</p>
        </div>
      </div><div class="accordion-item">
        <button type="button" class="accordion-header w-full flex justify-between items-center my-2 p-3 rounded" onclick="this.nextElementSibling.classList.toggle('max-h-0');this.nextElementSibling.classList.toggle('max-h-tall'); this.querySelector('.plus').classList.toggle('hidden'); this.querySelector('.minus').classList.toggle('hidden');">
          <p class="font-bold text-left" x-text="accordion.title">What if my team draws? </p>
          <svg xmlns="http://www.w3.org/2000/svg" class="plus h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" class="minus h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
          </svg>
        </button>
        <div class="accordion-content transition-maxheight ease-out duration-500 max-h-0 overflow-hidden mb-2">
          <p class="whitespace-pre-wrap" x-html="accordion.content">You only keep your lives intact if your team wins.<br>If your team loses or draws, you will lose a life.</p>
        </div>
      </div><div class="accordion-item">
        <button type="button" class="accordion-header w-full flex justify-between items-center my-2 p-3 rounded" onclick="this.nextElementSibling.classList.toggle('max-h-0');this.nextElementSibling.classList.toggle('max-h-tall'); this.querySelector('.plus').classList.toggle('hidden'); this.querySelector('.minus').classList.toggle('hidden');">
          <p class="font-bold text-left" x-text="accordion.title">Can I earn or buy more lives? </p>
          <svg xmlns="http://www.w3.org/2000/svg" class="plus h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" class="minus h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
          </svg>
        </button>
        <div class="accordion-content transition-maxheight ease-out duration-500 max-h-0 overflow-hidden mb-2">
          <p class="whitespace-pre-wrap" x-html="accordion.content">No, it is not possible to recover lost lives, or earn more than the three you start with.</p>
        </div>
      </div><div class="accordion-item">
        <button type="button" class="accordion-header w-full flex justify-between items-center my-2 p-3 rounded" onclick="this.nextElementSibling.classList.toggle('max-h-0');this.nextElementSibling.classList.toggle('max-h-tall'); this.querySelector('.plus').classList.toggle('hidden'); this.querySelector('.minus').classList.toggle('hidden');">
          <p class="font-bold text-left" x-text="accordion.title">What if I do not submit a selection before the deadline?</p>
          <svg xmlns="http://www.w3.org/2000/svg" class="plus h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" class="minus h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
          </svg>
        </button>
        <div class="accordion-content transition-maxheight ease-out duration-500 max-h-0 overflow-hidden mb-2">
          <p class="whitespace-pre-wrap" x-html="accordion.content">If you have joined and fail to submit a selection before the deadline you will be assigned the first team that you haven’t already selected, alphabetically. <br>For example, if you have already chosen Arsenal but haven’t used Aston Villa, you will be assigned Aston Villa.</p>
        </div>
      </div><div class="accordion-item">
        <button type="button" class="accordion-header w-full flex justify-between items-center my-2 p-3 rounded" onclick="this.nextElementSibling.classList.toggle('max-h-0');this.nextElementSibling.classList.toggle('max-h-tall'); this.querySelector('.plus').classList.toggle('hidden'); this.querySelector('.minus').classList.toggle('hidden');">
          <p class="font-bold text-left" x-text="accordion.title">What if the team I select has their game postponed</p>
          <svg xmlns="http://www.w3.org/2000/svg" class="plus h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" class="minus h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
          </svg>
        </button>
        <div class="accordion-content transition-maxheight ease-out duration-500 max-h-0 overflow-hidden mb-2">
          <p class="whitespace-pre-wrap" x-html="accordion.content">If you select a team from a game that is postponed, you will progress to the next Gameweek without losing a life.</p>
        </div>
      </div><div class="accordion-item">
        <button type="button" class="accordion-header w-full flex justify-between items-center my-2 p-3 rounded" onclick="this.nextElementSibling.classList.toggle('max-h-0');this.nextElementSibling.classList.toggle('max-h-tall'); this.querySelector('.plus').classList.toggle('hidden'); this.querySelector('.minus').classList.toggle('hidden');">
          <p class="font-bold text-left" x-text="accordion.title">What happens if everyone is eliminated and nobody wins. </p>
          <svg xmlns="http://www.w3.org/2000/svg" class="plus h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" class="minus h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
          </svg>
        </button>
        <div class="accordion-content transition-maxheight ease-out duration-500 max-h-0 overflow-hidden mb-2">
          <p class="whitespace-pre-wrap" x-html="accordion.content">If everyone is eliminated without a single Baller remaining, there will be a Ballover. <br>The game will restart, everyone wishing to play again must pay £10 entry fee and it will be added to the existing Prizepot. <br>All team selections are reset and the game starts again completely.</p>
        </div>
      </div><div class="accordion-item">
        <button type="button" class="accordion-header w-full flex justify-between items-center my-2 p-3 rounded" onclick="this.nextElementSibling.classList.toggle('max-h-0');this.nextElementSibling.classList.toggle('max-h-tall'); this.querySelector('.plus').classList.toggle('hidden'); this.querySelector('.minus').classList.toggle('hidden');">
          <p class="font-bold text-left" x-text="accordion.title">If I pick a later kickoff, will I be eliminated later than other Ballers? </p>
          <svg xmlns="http://www.w3.org/2000/svg" class="plus h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" class="minus h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
          </svg>
        </button>
        <div class="accordion-content transition-maxheight ease-out duration-500 max-h-0 overflow-hidden mb-2">
          <p class="whitespace-pre-wrap" x-html="accordion.content">No, kickoff times are not taken into account. Whoever loses a life in a Gameweek, loses it all at the same time. <br>You cannot prevent a Ballover by choosing a later kickoff.</p>
        </div>
      </div><div class="accordion-item">
        <button type="button" class="accordion-header w-full flex justify-between items-center my-2 p-3 rounded" onclick="this.nextElementSibling.classList.toggle('max-h-0');this.nextElementSibling.classList.toggle('max-h-tall'); this.querySelector('.plus').classList.toggle('hidden'); this.querySelector('.minus').classList.toggle('hidden');">
          <p class="font-bold text-left" x-text="accordion.title">Can I play if I am outside of the UK? </p>
          <svg xmlns="http://www.w3.org/2000/svg" class="plus h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" class="minus h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
          </svg>
        </button>
        <div class="accordion-content transition-maxheight ease-out duration-500 max-h-0 overflow-hidden mb-2">
          <p class="whitespace-pre-wrap" x-html="accordion.content">Yes, anyone over the age of 18 from anywhere in the world can join.</p>
        </div>
      </div><div class="accordion-item">
        <button type="button" class="accordion-header w-full flex justify-between items-center my-2 p-3 rounded" onclick="this.nextElementSibling.classList.toggle('max-h-0');this.nextElementSibling.classList.toggle('max-h-tall'); this.querySelector('.plus').classList.toggle('hidden'); this.querySelector('.minus').classList.toggle('hidden');">
          <p class="font-bold text-left" x-text="accordion.title">Can I play if I am under 18?</p>
          <svg xmlns="http://www.w3.org/2000/svg" class="plus h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" class="minus h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
          </svg>
        </button>
        <div class="accordion-content transition-maxheight ease-out duration-500 max-h-0 overflow-hidden mb-2">
          <p class="whitespace-pre-wrap" x-html="accordion.content">No. Due to the nature of the Last Man Balling rules, gambling activities regulated under the Gambling Act 2005 are restricted to over 18s.</p>
        </div>
      </div><div class="accordion-item">
        <button type="button" class="accordion-header w-full flex justify-between items-center my-2 p-3 rounded" onclick="this.nextElementSibling.classList.toggle('max-h-0');this.nextElementSibling.classList.toggle('max-h-tall'); this.querySelector('.plus').classList.toggle('hidden'); this.querySelector('.minus').classList.toggle('hidden');">
          <p class="font-bold text-left" x-text="accordion.title">Can I play if I don’t have social media?</p>
          <svg xmlns="http://www.w3.org/2000/svg" class="plus h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" class="minus h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
          </svg>
        </button>
        <div class="accordion-content transition-maxheight ease-out duration-500 max-h-0 overflow-hidden mb-2">
          <p class="whitespace-pre-wrap" x-html="accordion.content">Yes, but all players are encouraged to join the official Last Man Balling <a href="https://t.me/lastmanballing" target="_blank" rel="external">Telegram group</a> and follow @lastmanballing on <a href="https://twitter.com/lastmanballing" target="_blank" rel="external">Twitter</a> and <a href="https://instagram.com/lastmanballing" target="_blank" rel="external">Instagram</a> to keep up to date with the latest fixtures, selections, eliminations and more.</p>
        </div>
      </div><div class="accordion-item">
        <button type="button" class="accordion-header w-full flex justify-between items-center my-2 p-3 rounded" onclick="this.nextElementSibling.classList.toggle('max-h-0');this.nextElementSibling.classList.toggle('max-h-tall'); this.querySelector('.plus').classList.toggle('hidden'); this.querySelector('.minus').classList.toggle('hidden');">
          <p class="font-bold text-left" x-text="accordion.title">I missed the chance to sign up before Round 1. Can I still play? </p>
          <svg xmlns="http://www.w3.org/2000/svg" class="plus h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" class="minus h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
          </svg>
        </button>
        <div class="accordion-content transition-maxheight ease-out duration-500 max-h-0 overflow-hidden mb-2">
          <p class="whitespace-pre-wrap" x-html="accordion.content">Unfortunately, you cannot join mid-game. <br>However, in the event of a Ballover where no singular winner is declared, you will be able to join. <br>Please sign up to the <a href="#waitlist">Waiting List</a> below to be notified in the event of a Ballover. As soon as Round 1 starts, it will not be possible to pay the £10 entry fee to join the game.</p>
        </div>
      </div><div class="accordion-item">
        <button type="button" class="accordion-header w-full flex justify-between items-center my-2 p-3 rounded" onclick="this.nextElementSibling.classList.toggle('max-h-0');this.nextElementSibling.classList.toggle('max-h-tall'); this.querySelector('.plus').classList.toggle('hidden'); this.querySelector('.minus').classList.toggle('hidden');">
          <p class="font-bold text-left" x-text="accordion.title">Can I join multiple times?</p>
          <svg xmlns="http://www.w3.org/2000/svg" class="plus h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" class="minus h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
          </svg>
        </button>
        <div class="accordion-content transition-maxheight ease-out duration-500 max-h-0 overflow-hidden mb-2">
          <p class="whitespace-pre-wrap" x-html="accordion.content">No. All Ballers can only join once, and anyone found to be submitting multiple selections will be eliminated from the game and will not receive a refund.</p>
        </div>
      </div><div class="accordion-item">
        <button type="button" class="accordion-header w-full flex justify-between items-center my-2 p-3 rounded" onclick="this.nextElementSibling.classList.toggle('max-h-0');this.nextElementSibling.classList.toggle('max-h-tall'); this.querySelector('.plus').classList.toggle('hidden'); this.querySelector('.minus').classList.toggle('hidden');">
          <p class="font-bold text-left" x-text="accordion.title">Can I pay in advance for any potential Ballovers? </p>
          <svg xmlns="http://www.w3.org/2000/svg" class="plus h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" class="minus h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
          </svg>
        </button>
        <div class="accordion-content transition-maxheight ease-out duration-500 max-h-0 overflow-hidden mb-2">
          <p class="whitespace-pre-wrap" x-html="accordion.content">No, you can only pay £10 for the current game.</p>
        </div>
      </div>
  </div>
</div>

								</header>
								<footer class="major">
									<ul class="actions special">
										<li><a href="#rules" class="button primary">Rules</a></li>
										<li><a href="#join" class="button primary">Join</a></li>
										<li><a href="#header" class="button">Top of the Page</a></li>
									</ul>
								</footer>
							</section>

					
					
																			<!-- Waitlist -->
							<section id="waitlist" class="main special">
								<header class="major">
									<h2>Join the Waiting List</h2>
								</header>
								<ul class="features">
<div style="left: 0; width: 100%; height: 539px; position: relative;"><iframe src="https://docs.google.com/forms/d/e/1FAIpQLScht2MgSKtzcuXz_KRimaUKJbGYpyFzGRflJ8cVLidATwPQsg/viewform?embedded=true&usp=embed_googleplus" style="top: 0; left: 0; width: 100%; height: 100%; position: absolute; border: 0;" allowfullscreen></iframe></div>

								</ul>
								<footer class="major">
									<ul class="actions special">
									</ul>
								</footer>
							</section>

				<!-- Footer -->
					<footer id="footer">
						<section id="contact">
							<h2>Last Man Balling</h2>
							<p>After hosting a number of games among friends locally, the Last Man Balling team decided to create an online version of the infamous last man standing football prediction game, with the biggest Prizepot of them all up for grabs.</p>
							<ul class="actions">							
							<li><a href="#rules" class="button primary">Rules</a></li>
							<li><a href="#join" class="button primary">Join</a></li>
							<li><a href="#header" class="button">Top of the Page</a></li>
							</ul>
						</section>
						<section>
							<h2>Contact Us</h2>
							<dl class="alt">
								<dd>If you wish to discuss promotion opportunities or have any questions about Last Man Balling, please get in touch via emal.</dd>
								<dt>Email</dt>
								<dd><a href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;&#99;&#111;&#110;&#116;&#97;&#99;&#116;&#64;&#108;&#97;&#115;&#116;&#109;&#97;&#110;&#98;&#97;&#108;&#108;&#105;&#110;&#103;&#46;&#99;&#111;&#109;" target="_blank">&#99;&#111;&#110;&#116;&#97;&#99;&#116;&#64;&#108;&#97;&#115;&#116;&#109;&#97;&#110;&#98;&#97;&#108;&#108;&#105;&#110;&#103;&#46;&#99;&#111;&#109;</a></dd>
							</dl>
							<ul class="icons" align="center">
								<li><a href="https://t.me/lastmanballing" target="_blank" rel="external" class="icon brands fa-telegram alt"><span class="label">Telegram</span></a></li>
								<li><a href="https://twitter.com/lastmanballing" target="_blank" rel="external" class="icon brands fa-twitter alt"><span class="label">Facebook</span></a></li>
								<li><a href="https://instagram.com/lastmanballing" target="_blank" rel="external" class="icon brands fa-instagram alt"><span class="label">Instagram</span></a></li>
							</ul><align>
						</section>
						<p class="copyright" align="center">&copy; 2023 Last Man Balling</p></align>
					</footer>

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>		
	</body>
</html>
