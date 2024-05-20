<nav class="navbar navbar-custom navbar-fixed-top <?=(isset($nav_class)) ? $nav_class : ''; ?>" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#custom-collapse"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
      <!-- Big logo -->
      <a class="navbar-brand big-brand" href="<?=base_url()?>"><img src="<?=asset_url()?>images/logo-holi-coats-white.svg" /></a>
      <!-- Small logo -->
      <a class="navbar-brand small-brand" href="<?=base_url()?>"><img src="<?=asset_url()?>images/logo-holi-coats-white.svg" /></a>
      <div class="itens-m">
        <!-- Itens only mobile-->
        <!-- Search-->
        <a href="#search-m" class="search-btn"><i class="fa fa-search" aria-hidden="true"></i><span><?=$language['buscar'];?></span></a>
        <div id="search-m">
          <button type="button" class="close">×</button>
          <form action="<?=base_url()?>busca" >
            <input type="search" value="" name="produto" placeholder="Digite sua busca aqui..." />
            <button type="submit" class="btn btn-primary"><?=$language['buscar'];?></button>
          </form>
        </div>
        <!-- Cart-->
        <a href="<?=base_url()?>carrinho" class="cart-icon"><i class="icon-basket"></i><span><?=$cart_items_number?></span></a>
      </div>
      <!-- /Itens only mobile-->
    </div>
    <div class="collapse navbar-collapse" id="custom-collapse">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a class="dropdown-toggle" href="#" data-toggle="dropdown"><?=$language['jalecos'];?></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url()?>categoria/jaleco/feminino"><?=$language['feminino'];?></a></li>
            <li><a href="<?=base_url()?>categoria/jalecos/masculinos"><?=$language['masculino'];?></a></li>
          </ul>
        </li>
        <li><a href="<?=base_url()?>categoria/toucas"><?=$language['toucas'];?></a></li>
        <li><a href="<?=base_url()?>categoria/pijama-cirurgico"><?=$language['pijamas'];?></a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="icon-ribbon"></span> <?=$language['linhas_exclusivas']?></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url()?>categoria/linhas/rafa-puglisi">Rafa Puglisi by Holi Coats</a></li>
            <li><a href="<?=base_url()?>categoria/linhas/dsd-christian-coachman">DSD by Holi Coats</a></li>
            <li><a href="<?=base_url()?>jaleco-branco">White by Holi Coats</a></li>
          </ul>
        </li>
        <li><a href="<?=URL_BLOG?>" target="blank">Blog</a></li>
        <li class="language-nav">
          <a href="#" class="select-idiom" title="Português" data-idiom='portuguese'><img src="<?=asset_url()?>images/ic-portugues.svg" /></a>
          <a href="#" class="select-idiom usa-pR" title="English" data-idiom='english'><img src="<?=asset_url()?>images/ic-english.svg" /></a>
        </li>
        <li class="search-content">
          <a href="#search" class="search-btn"><i class="fa fa-search" aria-hidden="true"></i><span><?=$language['buscar'];?></span></a>
          <div id="search">
            <button type="button" class="close">×</button>
            <form action="<?=base_url()?>busca">
              <input type="search" value="" placeholder="Digite sua busca aqui..." name="produto" />
              <button type="submit" class="btn btn-primary"><?=$language['buscar'];?></button>
            </form>
          </div>
        </li>
        <li class="cart-content"><a href="<?=base_url()?>carrinho" class="cart-icon"><i class="icon-basket"></i><span><?=$cart_items_number?></span></a></li>
      </ul>
    </div>
  </div>
</nav>
