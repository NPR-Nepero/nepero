---
layout: default
title: Resources
---

# Resources

## Precarity in academia

### Who we are

The main obstacle in defining precarious work in higher education and research is the diversity of its forms in different countries, domain of research and even institutions,[^akerlind2005] [^eua2024report] and the resulting lack of aggregated data worldwide.[^oecd2021reducing]

### How we got here

Although the trajectory of precarious employment in academia has varied across countries, the majority of studies reports a pronounced increase in postdoctoral positions during the second half of the twentieth century, following earlier implementations in the United States[^mervis1999science] and United Kingdom.[^wikiJRF]

**United States.** The postdoctoral scholarship in the United States, traditionally rooted in the Old-European guild system (Master, Apprentice and Journeymen), dates back as early as the 1870s, with the Johns Hopkins University implementing it shortly after its foundation, and the Rockefeller Foundation establishing it formally in the 1920s for the physical sciences.[^nas2000] However, the scholarship model started taking its current form following World War II.[^micoli2018history] The change was driven by the scientific domain, deemed at the time as integral to national defense interests.[^bush1945frontier] The program was implemented in practice by the creation of the National Science Foundation (NSF) in 1950, the expansion of the National Institutes of Health (NIH) during the same period, and the institution, by the 1974 National Research Act, of the National Research Service Award (NRSA) for training researchers in the behavioral and health sciences.

<figure class="chart-figure">
  <canvas id="myChart"></canvas>
  <figcaption >
  <p markdown="1">
**Figure 1.** Evolution of the total number of doctorate recipients per year (all field),[^ncses2025sed] postodctoral appointees per year (science, engineering, health)[^ncses2026sgspse] in the United States.
</p>
  </figcaption>
</figure>

**France.** The postdoctoral scolarship was introduced in French academia much later than the above cases, given that, even in 1999, the country was maintaining "a 3-decade-old policy that says it would be unfair to offer people temporary posts with no promise of permanent employment".[^balter1999europe]

### What to do?

---

{% include refs.md %}



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
async function loadCSVData() {
    const response = await fetch('{{ "/assets/data/US_phd_postdoc_timeseries.csv" | relative_url }}');
    const text = await response.text();
    const rows = text.trim().split("\n").slice(1);
    const labels = [], data1 = [], data2 = [];
    rows.forEach(row => {
        const [date, value1, value2] = row.split(",");
        labels.push(date);
        data1.push(Number(value1));
        if (value2 === undefined || value2.trim() === "") {
        	data2.push(null);
	} else {
		data2.push(Number(value2));
	}
    });
    return { labels, data1, data2 };
}

async function renderChart() {
    const { labels, data1, data2 } = await loadCSVData();
    const ctx = document.getElementById('myChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
            {
                label: 'Doctorate recipients (all fields)',
                data: data1,
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.1)',
                fill: false,
                tension: 0.2
            },
            {
                label: 'Postdocs (SEH fields)',
                data: data2,
                borderColor: 'rgb(54, 162, 235)',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                fill: false,
                tension: 0.2
            },
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                x: {
                    title: { display: true, text: 'Year' }
                },
                y: {
                    title: { display: true, text: 'Number' }
                }
            }
        }
    });
}

renderChart();
</script>
