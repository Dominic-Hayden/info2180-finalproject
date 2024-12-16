<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$q_country = isset($_POST['country']) ? $_POST['country'] : '';
$q_lookup = isset($_POST['lookup']) ? $_POST['lookup'] : '';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

if ($q_lookup) {
  $stmt = $conn->query("SELECT c.name, c.district, c.population FROM cities c join countries cs on c.country_code = cs.code WHERE LOWER(cs.name) = LOWER('$q_country')");
  $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);

  echo "<table>
  <thead> 
    <tr>
      <th> Name </th>
      <th> District </th>
      <th> Population </th>
    </tr>
  </thead>
  <tbody>";
    foreach ($cities as $city){
    echo "<tr>
      <td>{$city['name']}</td>
      <td>{$city['district']}</td>
      <td>{$city['population']}</td>
    </tr>";
    }
  echo "</tbody>
</table>"; 
}

else{
  $stmt = $conn->query("SELECT * FROM countries WHERE name LIKE '%$q_country%'");
  $countries = $stmt->fetchAll(PDO::FETCH_ASSOC);

  echo "<table>
  <thead> 
    <tr>
      <th> Name </th>
      <th> Continent </th>
      <th> Independence </th>
      <th> Head Of State </th>
    </tr>
  </thead>
  <tbody>";
    foreach ($countries as $country){
    echo "<tr>
      <td>{$country['name']}</td>
      <td>{$country['continent']}</td>
      <td>{$country['independence_year']}</td>
      <td>{$country['head_of_state']}</td>
    </tr>";
    }
  echo "</tbody>
</table>";  
}

?>
