<script>
import { onMount } from 'svelte';
import axios from 'axios';
import Doughnut from './lib/Doughnut.svelte';
import BarChart from './lib/BarChart.svelte';
import { CountUp } from 'countup.js';
import dayjs from 'dayjs';

let totalEl;
let loading = false;
let pharmacist_id = null;
let mock_date = dayjs().format('YYYY-MM-DD');

let data = {
  dateRange: '',
  performance_title: '',
  performance_tooltip: '',
  ncs_title: '',
  ncs_tooltip: '',
  ncs_target: '',
  apc_score_title: '',
  apc_score_tooltip: '',
};

let stats = {
  cmr: 0,
  tmr: 0,
  medrec: 0,
  ncs_score: 0,
  apc_score: 0,
  calls: [],
  calls_values: [],
  calls_labels: [],
  total: 0,
};

let period = 'year_to_date';
let periods = [
  { value: 'year_to_date', label: 'Year to Date' },
  { value: 'last_month', label: 'Prior Month' },
  { value: 'month_to_date', label: 'Month to Date' },
  { value: 'last_week', label: 'Last Week' },
  { value: 'week_to_date', label: 'Week to Date' },
  { value: 'yesterday', label: 'Yesterday' },
];

function fetchData() {
  loading = true;
  let url = `${ajax_url}/?action=user_stats&period=${period}`;
  if (pharmacist_id) url += `&pharmacist_id=${pharmacist_id}`;
  if (mock_date) url += `&mock_date=${mock_date}`;
  axios.get(url)
    .then(response => {
      data = response.data;
      stats = response.data.stats;
    }).catch(err => {
      console.log(err);
    }).finally(() => {
      loading = false;
    });
}

function doCountup(total) {
  total = new CountUp( totalEl, total, {
    duration: 0.8,
  });
  total.start();
}

$: doCountup(stats.total)

onMount(() => {
  fetchData();
})
</script>

<div id="stats-inner">

  <div id="heading">
    <div class="desktop-only">
      <nav id="tabs">
        {#each periods as p}
          <label>
            <input type="radio" name="tab" bind:group={period} value={p.value} on:change={fetchData}>
            <span>{p.label}</span>
          </label>
        {/each}
      </nav>
    </div>

    <div class="mobile-only">
      <select bind:value={period} on:change={fetchData}>
        {#each periods as p}
          <option value={p.value}>{p.label}</option>
        {/each}
      </select>
    </div>
    <span id="updated">Data refreshed {data.last_updated}</span>
  </div>

  <div id="chart-container">
    <div class="row">
      <div class="performance">
        <h4>{data.performance_title}</h4>
        <div class="tooltip-container">
          <span class="tooltip">
            <i class="fas fa-info fa-fw"></i>
          </span>
          <span class="tooltip_text">{@html data.performance_tooltip}</span>
        </div>
        <p style="margin: 0; font-size: 13px;">Consult Type</p>
        <div class="stats">
          <div class="stat blue">CMR <span>{stats.cmr}</span></div>
          <div class="stat yellow">TMR <span>{stats.tmr}</span></div>
          <!-- <div class="stat red">MedRec <span>{stats.medrec}</span></div> -->
        </div>
      </div> 
      <div class="rounded yellow">
        <Doughnut title={data.ncs_title} score={stats.ncs_score} tooltip={data.ncs_tooltip} suffix='%' subtitle={data.ncs_target} />
      </div> 
      <div class="rounded red">
        <Doughnut title={data.apc_title} score={stats.apc_score} tooltip={data.apc_tooltip} suffix='' subtitle='' />
      </div>
    </div>

    <div class="row">
      <div class="bar-chart" style="width: 80%;">
        <BarChart title="My Total Calls" values={stats.calls_values} labels={stats.calls_labels} dateRange={data.dateRange} bgs={stats.calls_bgs} {loading} />
      </div>
      <div id="total_calls" style="width: 20%;">
        <h1 bind:this={totalEl}>{stats.total}</h1>
        <p>Total Calls</p>
      </div>
    </div>

  </div>

  {#if data.admin}
    <div class="admin-fields">
      <div>
        <label for="pharmacist_id">Pharmacist Id:</label>
        <input name="pharmacist_id" type="number" bind:value={pharmacist_id} on:change={fetchData} />
      </div>
      <div>
        <label for="mock_date">Mock Date:</label>
        <input name="mock_date" type="date" bind:value={mock_date} on:change={fetchData} />
      </div>
    </div>
  {/if}
</div>

<style>
:root {
  --blue: #46a4e3;
  --lightblue: #CEE0FC;
  --red: #ee5959;
  --yellow: #e8a838;
  --tier-bronze: #FFA04E;
  --tier-silver: #FE6C38;
  --tier-gold: #086ACD;
  --tier-platinum: #5C00DE;
}

#stats-inner {
  text-align: left;
}

.row {
  margin: 20px auto;
}

.row > * {
  margin: 20px auto;
}

.desktop-only {
  display: none;
}

#heading select {
  display: block;
  width: 100%;
  margin: 20px auto;
}

@media (min-width: 740px) {
  .desktop-only {
    display: initial;
  }

  .mobile-only {
    display: none;
  }

  #stats-inner {
    margin-right: 10px;
  }

  #heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-right: 10px;
  }

  .row {
    display: flex;
    justify-content: space-evenly;
    gap: 20px;
  }

  .row > * {
    width: 33%;
    margin: 0;
  }

  .admin-fields {
    display: flex;
    justify-content: space-between;
  }
}

.admin-fields {
  margin: 20px auto 0;
}

.admin-fields label,
.admin-fields input {
  display: block;
  width: 100%;
}

.rounded {
  border-radius: 15px;
}

.yellow {
  background: var(--yellow);
  color: white;
}

.red {
  background: var(--red);
  color: white;
}

.blue {
  background: var(--blue);
  color: white;
}

#tabs {
  border-radius: 100rem;
  border: 1px solid lightgray;
  display: inline-flex;
  margin: 20px 0;
}

#tabs label > span {
  border-radius: 16px;
  display: inline-block;
  cursor: pointer;
  padding: 6px 12px;
  font-size: 12px;
  color: #55595f;
}

#tabs input[type=radio] {
  display: none;
}

#tabs label:hover > span {
  background: lightgray;
}

#tabs input[type=radio]:checked ~ span {
  background: var(--blue);
  color: white;
  z-index: 2;
  position: relative;
}

#updated {
  font-size: 11px;
  font-style: italic;
  text-align: right;
  color: #aaa;
}

#chart-container {
  background: white;
  border-radius: 20px;
  padding: 20px;
}

.performance {
  position: relative;
}

.performance h4 {
  margin-top: 4px;
}

.performance .stat {
  position: relative;
  margin: 5px auto;
  border-radius: 20px;
  padding: 12px 18px;
  font-size: 18px;
}

.performance .stat > span {
  position: absolute;
  right: 20px;
  font-weight: bold;
  font-size: 22px;
}

#total_calls {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

#total_calls h1 {
  margin: 0;
}
#total_calls p {
  white-space: nowrap;
  margin: 0;
}
.tooltip-container {
  position: absolute !important;
  right: 5px;
  top: 10px;
}
.tooltip-container > span.tooltip {
  color: var(--blue);
  border: 2px solid var(--blue);
  border-radius: 8px;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 20px;
  height: 20px;
}
.fa-info {
  font-size: 8px;
}
.tooltip {
  margin: 0;
}
.tooltip_text {
  right: 0;
  left: auto;
}
</style>
