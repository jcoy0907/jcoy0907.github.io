var cell;
var mass = [];
var zoom = 1;

function setup() {
  createCanvas(600, 600);
  cell = new Blob(Math.round(random(-width,width)), Math.round(random(-width,width)), 25);
  for (var i = 0; i <= 400; i++) {
    var x = random(-width,width);
    var y = random(-height,height);
    mass[i] = new Blob(x, y, 5);
  }
}

function draw() {
  background(0);

  translate(width/2, height/2);
  var newzoom = 40 / cell.r;
  zoom = lerp(zoom, newzoom, 0.15);
  scale(zoom);
  translate(-cell.pos.x, -cell.pos.y);

  for (var i = mass.length-1; i >=0; i--) {
    mass[i].show();
    if (cell.eats(mass[i])) {
      mass.splice(i, 1);
    }
  }


  cell.show();
  cell.update();

}
