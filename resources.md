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

**United States.** The postdoctoral scholarship in the United States, traditionally rooted in the Old-European guild system (Master, Apprentice and Journeymen), dates back as early as the 1870s, with the Johns Hopkins University implementing it shortly after its foundation, and the Rockefeller Foundation establishing it formally for the physical sciences in the 1920s.[^nas2000] However, the scholarship model started taking its current form following World War II.[^micoli2018history] The change was driven by the scientific domain, deemed at the time as integral to national defense interests.[^bush1945frontier] The program was implemented in practice by the creation of the National Science Foundation (NSF) in 1950, the expansion of the National Institutes of Health (NIH) during the same period, and the institution, by the 1974 National Research Act, of the National Research Service Award (NRSA) in the behavioral and health sciences.

<figure class="chart-figure">
  <canvas id="myChart"></canvas>
  <figcaption >
  <p markdown="1">
**Figure 1.** Evolution of the total number of doctorate recipients per year in research (mainly PhDs; professional doctoral degrees, such as MD, DDS, DVM, JD, DPharm, DMin, and PsyD, are excluded),[^ncses2025sed] postodctoral appointees per year in science, engineering, health (defined as those who (i) hold a recent doctoral degree or first-professional degree in a medical or related field and (ii) have a limited-term appointment)[^ncses2026sgspse] and other doctorate-holding nonfaculty researchers in science, engineering, health (all those who are not considered either postdocs or members of the faculty)[^ncses2026sgspse] in the United States. Census data.
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
    const labels = [], data1 = [], data2 = []; data3 = [];
    rows.forEach(row => {
        const [date, value1, value2, value3] = row.split(",");
        labels.push(date);
        data1.push(Number(value1));
        if (value2 === undefined || value2.trim() === "") {
        	data2.push(null);
	} else {
		data2.push(Number(value2));
	}
	if (value3 === undefined || value3.trim() === "") {
        	data3.push(null);
	} else {
		data3.push(Number(value3));
	}
    });
    return { labels, data1, data2, data3 };
}

async function renderChart() {
    const { labels, data1, data2, data3 } = await loadCSVData();
    const ctx = document.getElementById('myChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
            {
                label: 'Doctorate recipients (research)',
                data: data1,
                borderColor: 'rgb(0, 114, 178)',
                backgroundColor: 'rgba(0, 114, 178, 0.1)',
                fill: false,
                tension: 0.2
            },
            {
                label: 'Postdocs (SEH)',
                data: data2,
                borderColor: 'rgb(213, 94, 0)',
                backgroundColor: 'rgba(213, 94, 0, 0.1)',
                fill: false,
                tension: 0.2
            },
            {
                label: 'Other doctorate-holding nonfaculty (SEH)',
                data: data3,
                borderColor: 'rgb(0, 158, 115)',
                backgroundColor: 'rgba(0, 158, 115, 0.1)',
                fill: false,
                tension: 0.2
            },
            ]
        },
        options: {
            responsive: true,
            aspectRatio: 1.5,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                x: {
                    title: { display: true, text: 'year' }
                },
                y: {
                    title: { display: true, text: 'number' }
                }
            }
        }
    });
}

renderChart();
</script>
