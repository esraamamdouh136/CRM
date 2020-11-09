window.onload = function () {
	var chart = new CanvasJS.Chart("chartContainer", {
		theme: "light2",
		title:{
			text: "Print Chart using print() method"              
		},
		data: [              
		{
			type: "column",
			dataPoints: [
				{ label: "apple",  y: 10  },
				{ label: "orange", y: 15  },
				{ label: "banana", y: 25  },
				{ label: "mango",  y: 30  },
				{ label: "grape",  y: 28  }
			]
		}
		]
	});
  
	chart.render();
  	document.getElementById("printChart").addEventListener("click",function(){
    	chart.print();
    });  	
}
