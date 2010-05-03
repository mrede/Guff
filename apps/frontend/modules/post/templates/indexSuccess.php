<h1>Local messages</h1>

<table>
  <thead>
    <tr>


      <th>Text</th>
      <th>Created at</th>

    </tr>
  </thead>
  <tbody>
    <?php foreach ($posts as $post): ?>
    <tr>


      <td><?php echo $post->getText() ?></td>

      <td><?php echo Utilities::timeSince(strtotime($post->getCreatedAt())) ?> ago</td>

    </tr>
    <?php endforeach; ?>
  </tbody>
</table>