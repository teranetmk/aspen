<script>
import { onMount } from 'svelte';
import axios from 'axios';
import Doughnut from './lib/Doughnut-v3.svelte';
import BarChart from './lib/BarChart-v3.svelte';
import { CountUp } from 'countup.js';
import dayjs from 'dayjs';

let totalEl;
let loading = false;
let pharmacist_id = null;
let data_type = 'cmr';
let mock_date = dayjs().format('YYYY-MM-DD');
let showMenu = false;

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
  apc_cmr: 0,
  apc_tmr: 0,
  ncs_cmr: 0,
  ncs_tmr: 0,
  calls: [],
  calls_values: [],
  calls_labels: [],
  total: 0,
};

let period = 'last_month';
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
  let url = `${ajax_url}/?action=user_stats_v3&data_type=${data_type}&period=${period}`;
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

function setType(dt) {
  data_type = dt;
  showMenu = false;
  fetchData();
}

let toggleButtonText = '';
$: if (data_type === 'calls') {
  toggleButtonText = "Total Calls";
} else if (data_type === 'tmr') {
  toggleButtonText = "TMRs Completed";
} else {
  toggleButtonText = "CMRs Completed";
}

$: doCountup(stats.total)

onMount(() => {
  fetchData();
})
</script>

<div id="stats-inner">

  <div id="chart-container">
    <div>
        <h4 class="performance-title">{data.performance_title}</h4>
        <span id="updated">Data refreshed {data.last_updated}</span>
    </div>

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
    </div>

    <div class="row">
      <div class="bar-chart" style="width: 100%;">
        <h4 class="title">Completes/Calls</h4>
        <div class="dataToggle-container">
          <button class="dataToggle" on:click|preventDefault={() => showMenu = !showMenu}>{toggleButtonText}
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align: bottom;">
              <path d="M7.11602 14.3507L11.3209 9.86676C11.8175 9.3372 11.7905 8.49764 11.261 8.00105L6.77696 3.79619" stroke="#1073CF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
          {#if showMenu}
          <div class="dataMenu">
            {#if data_type !== 'cmr'}
              <li><a on:click|preventDefault={() => setType('cmr')}>CMRs Completed</a></li>
            {/if}
            {#if data_type !== 'tmr'}
              <li><a on:click|preventDefault={() => setType('tmr')}>TMRs Completed</a></li>
            {/if}
            {#if data_type !== 'calls'}
              <li><a on:click|preventDefault={() => setType('calls')}>Total Calls</a></li>
            {/if}
          </div>
          {/if}
        </div>
        <h4 class="title" style="text-align: right; font-weight: 400;">
          {#if data_type === 'cmr'}
            Total CMRs:
          {/if}
          {#if data_type === 'tmr'}
            Total TMRs:
          {/if}
          {#if data_type === 'calls'}
            Total Calls:
          {/if}
          <span bind:this={totalEl} style="color: var(--new-blue);">{stats.total}</span></h4>
        <BarChart title=""
          values={stats.calls_values}
          labels={stats.calls_labels}
          dateRange={data.dateRange}
          showXAxis={true}
          showYAxis={true}
          showXGrid={true}
          showYGrid={true}
          {loading}
        />
      </div>
    </div>

    {#if data_type === 'cmr' || data_type === 'tmr'}
    <div class="row">
      <div class="rounded">
        <Doughnut title={`My ${data_type.toUpperCase()} NCS Score`} score={stats[`ncs_${data_type}`]} tooltip={data[`ncs_${data_type}_tooltip`]} />
      </div> 
      <div class="rounded">
        <Doughnut title={`My ${data_type.toUpperCase()} APC Score`} score={stats[`apc_${data_type}`]} tooltip={data[`apc_${data_type}_tooltip`]} />
      </div>
    </div>
    {/if}

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
  --new-blue: #1073CF;
  --lightblue: #CEE0FC;
  --red: #ee5959;
  --yellow: #e8a838;
  --tier-silver: #B1B7C6;
  --tier-gold: #E8A838;
  --tier-platinum: #1073CF;
}

#stats-inner {
  text-align: left;
  margin: 30px auto;
}

.row {
  margin: 30px auto;
}

.row > * {
  margin: 30px auto;
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
    justify-content: center;
    align-items: center;
    padding-right: 10px;
  }

  .row {
    display: flex;
    justify-content: space-between;
    gap: 40px;
  }

  .row > * {
    width: 50%;
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
  border: 1px solid var(--new-blue);
}

#tabs {
  border-radius: 100rem;
  border: 1px solid lightgray;
  display: inline-flex;
  margin: 20px 0;
}

#tabs label:not(:last-child) {
  border-right: 1px solid lightgray;
  padding: 0px 8px;
}

#tabs label:first-child {
  padding: 0;
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
  background: #FFA04E;
  color: white;
  z-index: 2;
  position: relative;
}

#updated {
  font-size: 10px;
  color: #55595F;
}

#chart-container {
  background: white;
  border-radius: 20px;
  padding: 20px;
}

h4.title {
  font-weight: 400;
  margin-bottom: 0px;
  color: #333333;
  font-size: 20px;
}

.performance-title {
  font-family: "DM Serif Display" !important;
  font-weight: 400;
  font-size: 37px;
  margin-top: 4px;
  line-height: 1;
  color: #050127;
  margin-bottom: 0px;
}
.dataToggle-container {
  position: relative;
  display: inline-block;
  background: transparent;
  border: 1px solid black;
  padding: 6px 10px;
  border-radius: 20px;
  margin: 5px 0;
  color: var(--new-blue);
  font-family: "Montserrat" !important;
}
.dataToggle{
  display: inline-block;
  background: transparent;
  border: 0px;
  color: var(--new-blue);
  cursor: pointer;
  font-family: "Montserrat" !important;
}
.dataToggle:hover {
  text-decoration: underline;
}
.dataMenu {
  background: white;
  border-radius: 10px;
  padding: 10px;
  position: absolute;
  width: 100%;
  top: 43px;
  z-index: 9999;
  color: var(--new-blue);
  left: 0px;
  font-family: "Montserrat" !important;
  filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));
  border: 1px solid rgba(229, 229, 229, 0.71);
  min-width: 170px;
}
.dataMenu li a {
  color: var(--new-blue);
}
.dataMenu li {
  list-style: none;
}
.dataMenu a:hover {
  cursor: pointer;
  text-decoration: underline;
}
</style>
