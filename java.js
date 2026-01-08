(function(){
	const THEME_KEY = 'theme';
	const btn = document.getElementById('theme-toggle');
	const icon = document.getElementById('theme-icon');

	function applyTheme(theme){
		if(theme === 'dark'){
			document.documentElement.setAttribute('data-theme','dark');
			if(icon){ icon.className = 'bi bi-sun-fill'; }
			if(btn) btn.setAttribute('aria-label','Switch to light theme');
		} else {
			document.documentElement.removeAttribute('data-theme');
			if(icon){ icon.className = 'bi bi-moon-fill'; }
			if(btn) btn.setAttribute('aria-label','Switch to dark theme');
		}
	}

	function getPreferredTheme(){
		const stored = localStorage.getItem(THEME_KEY);
		if(stored === 'light' || stored === 'dark') return stored;
		const mq = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
		return mq ? 'dark' : 'light';
	}

	function toggleTheme(){
		const current = document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
		const next = current === 'dark' ? 'light' : 'dark';
		applyTheme(next);
		localStorage.setItem(THEME_KEY, next);
	}

	document.addEventListener('DOMContentLoaded', function(){
		// initialize
		const initial = getPreferredTheme();
		applyTheme(initial);

		if(btn){
			btn.addEventListener('click', function(e){
				e.preventDefault();
				toggleTheme();
			});
		}
	});
})();

