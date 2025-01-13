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
      name: "Final Sekolah 1",
        info: "Point",
        children: [
          {
            name: "Semi Final Sekolah 1",
            info: "Point",
            children: [
              { name: "Penyisihan Sekolah 1", info: "Point" },
              { name: "Penyisihan Sekolah 2", info: "Point" },
              { name: "Penyisihan Sekolah 3", info: "Point" }
            ]
          },
          {
            name: "Semi Final Sekolah 5",
            info: "Point",
            children: [
              { name: "Penyisihan Sekolah 4", info: "Point" },
              { name: "Penyisihan Sekolah 5", info: "Point" },
              { name: "Penyisihan Sekolah 6", info: "Point" }
            ]
          },
          {
            name: "Semi Final Sekolah 9",
            info: "Point",
            children: [
              { name: "Penyisihan Sekolah 7", info: "Point" },
              { name: "Penyisihan Sekolah 8", info: "Point" },
              { name: "Penyisihan Sekolah 9", info: "Point" }
            ]
          }
        ]
    };

    // const data = @json($data);

    const width = 1000;
    const height = 800;

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