
<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
    $mes;

?>         
<table summary="a calendar">
			<caption>
				<a href="#" rel="prev">&lt</a> March 2017 <a href="#" rel="next">&gt</a>
			</caption>

			<thead>
				<tr>
					<th scope="col">Sun</th>
					<th scope="col">Mon</th>
					<th scope="col">Tue</th>
					<th scope="col">Wed</th>
					<th scope="col">Tur</th>
					<th scope="col">Fri</th>
					<th scope="col">Sat</th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td class="null">30</td>
					<td class="null">31</td>
					<td><a href="#">1<i class="fa fa-user-md"></i></a></td>
					<td><a href="#">2</a></td>
					<td><a href="#">3</a></td>
					<td><a href="#">4</a></td>
					<td><a href="#">5</a></td>
				</tr>

				<tr>
					<td><a href="#">6</a></td>
					<td><a href="#">7</a></td>
					<td><a href="#">8</a></td>
					<td><a href="#">9</a></td>
					<td><a href="#">10</a></td>
					<td class="selected"><a href="#">11</a></td>
					<td><a href="#">12</a></td>
				</tr>

				<tr>
					<td><a href="#">13</a></td>
					<td><a href="#">14</a></td>
					<td><a href="#">15</a></td>
					<td><a href="#">16</a></td>
					<td><a href="#">17</a></td>
					<td><a href="#">18</a></td>
					<td><a href="#">19</a></td>
				</tr>


				<tr>
					<td><a href="#">20</a></td>
					<td><a href="#">21</a></td>
					<td><a href="#">22</a></td>
					<td><a href="#">23</a></td>
					<td><a href="#">24</a></td>
					<td><a href="#">25</a></td>
					<td><a href="#">26</a></td>
				</tr>

				<tr>
					<td><a href="#">27</a></td>
					<td><a href="#">28</a></td>
					<td><a href="#">29</a></td>
					<td><a href="#">30</a></td>
					<td><a href="#">31</a></td>
					<td class="null">1</td>
					<td class="null">2</td>
				</tr>

			</tbody>


		</table>


        <style>
*{
	margin: 0;
	border: 0;
	padding: 0;
}

html,body{
	width: 100%;
	height: 100%;
  background: linear-gradient(to left, #212333, #432132);
}

caption{
	background: blue;
	height: 3em;
	line-height: 3em;
	box-shadow: 3px 0 2px black;
	color: white;
  font-family: 'Josefin Sans', sans-serif;
}

caption a{
	color: white;
}

table{
	background: #ddd;
	position: fixed;
	top: 50%;
	left: 50%;
	transform: translate(-50%,-50%);
	font-size: 20px;
	border-collapse: collapse;
	box-shadow: 3px 3px 2px black;
}

table,th,tr {
	text-align: center;
	vertical-align: middle;
}

table thead th{
	border: solid 1px white; 
	width: 3em;
	height: 2em;
	font-weight: 900;
  font-family: 'Josefin Sans', sans-serif;
}

table tbody td{
	border: solid 1px white;
	height: 2.7em;
}

a{
	text-decoration: none;
  font-family: 'Josefin Sans', sans-serif;
}

tbody a{
	display: block;
	height: 100%;
	display:flex;
	align-items: center;
	justify-content: center;
	color: black;
  
}


tbody a:hover{
	background: blue;
	color: white;
}

.null{
	color: gray;
  font-family: 'Josefin Sans', sans-serif;
}

.selected{
	background: blue;
}

.selected a{
	color: white;
}

        </style>