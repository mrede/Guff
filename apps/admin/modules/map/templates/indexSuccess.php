<h1>Map views List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Name</th>
      <th>Pitch</th>
      <th>Yaw</th>
      <th>Roll</th>
      <th>Created at</th>
      <th>Updated at</th>
      <th>Latitude</th>
      <th>Longitude</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($map_views as $map_view): ?>
    <tr>
      <td><a href="<?php echo url_for('map/edit?id='.$map_view->getId()) ?>"><?php echo $map_view->getId() ?></a></td>
      <td><?php echo $map_view->getName() ?></td>
      <td><a href='/mapview/<?php echo $map_view->getSlug()?>'>view</a>
      <td><?php echo $map_view->getUpdatedAt() ?></td>
      <td><?php echo $map_view->getLatitude() ?></td>
      <td><?php echo $map_view->getLongitude() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('map/new') ?>">New</a>
