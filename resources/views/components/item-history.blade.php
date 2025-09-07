@props(["history"])
<script src="https://cdn.plot.ly/plotly-3.1.0.min.js" charset="utf-8"></script>
<div id="history-plot"></div>

<script>
    let x = [];
    let y = [];

    for (elem of @json($history)) {
        let best_buy = elem.best_buy ? parseFloat(elem.best_buy.replace(/[,c]/g, '')) : null;
        let best_sell = elem.best_sell ? parseFloat(elem.best_sell.replace(/[,c]/g, '')) : null;
        console.log(best_buy, best_sell);
        let mid_market = (((best_buy ?? best_sell)) + (best_sell ?? best_buy)) / 2;
        y.push(mid_market);
        x.push(elem.time);
    }

    var data = [
        // buy
        {
            name: "Mid-market price",
            x: x,
            y: y,
            type: 'scatter',
            line: {
                color: 'blue',
            },
            marker: {
                size: 8
            },
            mode: "lines+markers",
        },
    ];
    var layout = {
        xaxis: {
            title: {
                text: "Time"
            }
        },
        yaxis: {
            title: {
                text: "Coins"
            }
        },
        showlegend: true
    }
    Plotly.newPlot('history-plot', data, layout);
</script>
