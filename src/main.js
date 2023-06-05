import Stats from './Stats.svelte'
import StatsV3 from './StatsV3.svelte'
import CSPBar from './lib/CSPBar.svelte'

document.querySelectorAll('#aspen-user-stats').forEach(function(el) {
  el.innerHTML = '';
  new Stats({
    target: el,
  });
});

document.querySelectorAll('#aspen-user-stats-v3').forEach(function(el) {
  el.innerHTML = '';
  new StatsV3({
    target: el,
  });
});

document.querySelectorAll('#aspen-user-csp-bar').forEach(function(el) {
  el.innerHTML = '';
  new CSPBar({
    target: el,
    props: {
      csp: el.dataset.csp,
    },
  });
});
// export default stats
