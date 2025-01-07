<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
  <script src="https://d3js.org/d3.v7.min.js"></script>
  <style>
    .link {
      fill: none;
      stroke: #ccc;
      stroke-width: 2px;
    }
    .card {
      font-family: sans-serif;
      font-size: 12px;
      background: #f9f9f9;
      border: 2px solid #ddd;
      border-radius: 4px;
      padding: 5px;
    }
  </style>
</head>
<body>
  <script>
    const data = {
      name: "Prov 1",
      info: "Champion",
      children: [
        {
          name: "Prov 1",
          info: "Grand Final",
          children: [
            {
              name: "Prov 1",
              info: "Final",
              children: [
                {
                  name: "Prov 1",
                  info: "Semi Final",
                  children: [
                    { name: "Prov 1", info: "Penyisihan" },
                    { name: "Prov 2", info: "Penyisihan" },
                    { name: "Prov 3", info: "Penyisihan" }
                  ]
                },
                {
                  name: "Prov 4",
                  info: "Semi Final",
                  children: [
                    { name: "Prov 4", info: "Penyisihan" },
                    { name: "Prov 5", info: "Penyisihan" },
                    { name: "Prov 6", info: "Penyisihan" }
                  ]
                },
                {
                  name: "Prov 7",
                  info: "Semi Final",
                  children: [
                    { name: "Prov 7", info: "Penyisihan" },
                    { name: "Prov 8", info: "Penyisihan" },
                    { name: "Prov 9", info: "Penyisihan" }
                  ]
                }
              ]
            },
            {
              name: "Prov 10",
              info: "Final",
              children: [
                {
                  name: "Prov 10",
                  info: "Semi Final",
                  children: [
                    { name: "Prov 10", info: "Penyisihan" },
                    { name: "Prov 11", info: "Penyisihan" },
                    { name: "Prov 12", info: "Penyisihan" }
                  ]
                },
                {
                  name: "Prov 13",
                  info: "Semi Final",
                  children: [
                    { name: "Prov 13", info: "Penyisihan" },
                    { name: "Prov 14", info: "Penyisihan" },
                    { name: "Prov 15", info: "Penyisihan" }
                  ]
                },
                {
                  name: "Prov 16",
                  info: "Semi Final",
                  children: [
                    { name: "Prov 16", info: "Penyisihan" },
                    { name: "Prov 17", info: "Penyisihan" },
                    { name: "Prov 18", info: "Penyisihan" }
                  ]
                }
              ]
            },
            {
              name: "Prov 19",
              info: "Final",
              children: [
                {
                  name: "Prov 19",
                  info: "Semi Final",
                  children: [
                    { name: "Prov 19", info: "Penyisihan" },
                    { name: "R 1 (Prov 2)", info: "Penyisihan" },
                    { name: "R 2 (Prov 3)", info: "Penyisihan" }
                  ]
                },
                {
                  name: "R 5 (Prov 4)",
                  info: "Point 100 Bobot 50"
                },
                {
                  name: "R 6 (Prov 7)",
                  info: "Point 100 Bobot 50"
                }
              ]
            }
          ]
        },
        {
          name: "Prov 20",
          info: "Grand Final",
          children: [
            {
              name: "Prov 20",
              info: "Final",
              children: [
                {
                  name: "Prov 20",
                  info: "Semi Final",
                  children: [
                    { name: "Prov 20", info: "Penyisihan" },
                    { name: "Prov 21", info: "Penyisihan" },
                    { name: "Prov 22", info: "Penyisihan" }
                  ]
                },
                {
                  name: "Prov 23",
                  info: "Semi Final",
                  children: [
                    { name: "Prov 23", info: "Penyisihan" },
                    { name: "Prov 24", info: "Penyisihan" },
                    { name: "Prov 25", info: "Penyisihan" }
                  ]
                },
                {
                  name: "Prov 26",
                  info: "Semi Final",
                  children: [
                    { name: "Prov 26", info: "Penyisihan" },
                    { name: "Prov 27", info: "Penyisihan" },
                    { name: "Prov 28", info: "Penyisihan" }
                  ]
                }
              ]
            },
            {
              name: "Prov 32",
              info: "Final",
              children: [
                {
                  name: "Prov 29",
                  info: "Semi Final",
                  children: [
                    { name: "Prov 29", info: "Penyisihan" },
                    { name: "Prov 30", info: "Penyisihan" },
                    { name: "Prov 31", info: "Penyisihan" }
                  ]
                },
                {
                  name: "Prov 32",
                  info: "Semi Final",
                  children: [
                    { name: "Prov 32", info: "Penyisihan" },
                    { name: "Prov 33", info: "Penyisihan" },
                    { name: "Prov 34", info: "Penyisihan" }
                  ]
                },
                {
                  name: "Prov 35",
                  info: "Semi Final",
                  children: [
                    { name: "Prov 35", info: "Penyisihan" },
                    { name: "Prov 36", info: "Penyisihan" },
                    { name: "Prov 37", info: "Penyisihan" }
                  ]
                }
              ]
            },
            {
              name: "Prov 38",
              info: "Final",
              children: [
                {
                  name: "Prov 38",
                  info: "Semi Final",
                  children: [
                    { name: "Prov 38", info: "Penyisihan" },
                    { name: "R 3 (Prov 20)", info: "Penyisihan" },
                    { name: "R 4 (Prov 21)", info: "Penyisihan" }
                  ]
                },
                {
                  name: "R 7 (Prov 23)",
                  info: "Semi Final"
                },
                {
                  name: "R 8 (Prov 26)",
                  info: "Semi Final"
                }
              ]
            }
          ]
        },
        {
          name: "R 9 (Prov 38)",
          info: "Final"
        }
      ]
    };

    const width = 4000;
    const height = 2500;

    const svg = d3.select("body")
      .append("svg")
      .attr("width", width)
      .attr("height", height);

    const root = d3.hierarchy(data);

    const treeLayout = d3.tree().size([height - 100, width - 200]);
    treeLayout(root);

    svg.selectAll(".link")
      .data(root.links())
      .enter()
      .append("path")
      .attr("class", "link")
      .attr("d", d => {
        return `M${width - (d.source.y + 100)},${d.source.x}
                H${width - ((d.source.y + d.target.y + 100) / 2)}
                V${d.target.x}
                H${width - (d.target.y + 100)}`;
      });

    const node = svg.selectAll(".node")
      .data(root.descendants())
      .enter()
      .append("g")
      .attr("class", "node")
      .attr("transform", d => `translate(${width - (d.y + 100)},${d.x})`);

    node.append("foreignObject")
      .attr("width", 120)
      .attr("height", 50)
      .attr("x", -60)
      .attr("y", -25)
      .append("xhtml:div")
      .attr("class", "card")
      .html(d => `
        <strong>${d.data.name}</strong>
        <br>${d.data.info}
      `);
  </script>
</body>
</html>