<nav class="navbar navbar-static-top">
  <!-- Sidebar toggle button -->
  <a href="#" class="sidebar-toggle btn" data-toggle="offcanvas" role="button">
    <span class="sr-only">Menu</span>
  </a>
  
  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">

      <li class="notifications-menu hidden-xs">
        <span style="float:left;margin:16px 4px;font-weight:bold;white-space:nowrap;color:#FFF;">
          <?= $this->request->Session()->read('debug') ? '<i class="fa fa-bug"></i>&nbsp;' : ''; ?>
          <?= date('d/m/Y ') ?> &nbsp;|&nbsp; <span id="timer"><?= date('H:i:s') ?></span>&nbsp;|&nbsp;
        </span>
      </li>

      <li class="notifications-menu">
          <span style="float:left;margin-top:16px;white-space:nowrap;color:#FFF;">
            <span class="hidden-xs"><?= __('Sua sessão expira em: ') ?></span><span class="text-bold" id="countdown"></span>
            <span id="server_datetime" style="visibility: hidden; position: absolute;"><?= date('M d Y H:i:s') ?></span>
            <script>
              setInterval(function () {
                  var current_date = new Date(document.getElementById("server_datetime").innerHTML);
                  document.getElementById("server_datetime").innerHTML = new Date(current_date.setSeconds(current_date.getSeconds() + 1));
              }, 1000);
              
              window.onload = function () {
                  
                  var session_timeout, current_date, target_date, hours, minutes, seconds;
                  var countdown = document.getElementById("countdown");
                  
                  //Timeout do sistema
                  session_timeout = <?= $this->request->Session()->read('Session.timeout'); ?>;
                  
                  current_date = new Date(document.getElementById("server_datetime").innerHTML);
                  target_date  = new Date(current_date.setMinutes(current_date.getMinutes() + parseInt(session_timeout)));
                  
                  setInterval(function () {
                      
                      //var current_date = new Date();
                      current_date = new Date(document.getElementById("server_datetime").innerHTML);
                      var seconds_left = (target_date - current_date) / 1000;
                      
                      //console.log("Target Date: " + target_date);
                      //console.log("Current Date: " + current_date);

                      minutes = parseInt(seconds_left / 60);
                      seconds = parseInt(seconds_left % 60);

                      if (minutes >= 0 && minutes < 10) {
                          minutes = "0" + minutes;
                      }
                      if (seconds >= 0 && seconds < 10) {
                          seconds = "0" + seconds;
                      }

                      if (minutes < 0 || seconds < 0) {
                          //location.reload(); 
                      } else {
                          if (minutes < 1 && seconds < 1) {
                              //location.reload(); 
                              location.href = "<?= $this->Url->build('/logout', true); ?>";
                          } else {
                              countdown.innerHTML = minutes + ":" + seconds;
                          }
                      }
                  }, 1000);
                  
              }//window.onload = function()
            </script>
          </span>
      </li>

      <!-- User Account: style can be found in dropdown.less -->
      <li class="dropdown user user-menu">
        <?php 
          if ($this->request->Session()->read('logomarca')) {
              $this->Html->link($this->Html->image($this->request->Session()->read('logomarca'), ['alt'    => 'logomarca',
                                                                                                  'height' => '38px'
                                                                                                  ]),
                                      ['controller'        => 'UsersParameters', 'action' => 'changeParameter'],
                                      ['class'             => 'btn btn_modal font-16',
                                        'data-size'         => 'sm',
                                        'data-loading-text' => '',
                                        'data-title'        => 'Mudar de Perfil',
                                        'escape'            => false
                                      ]);
          } else { ?>
            <span style="color:#f6f6f6;font-size:14px;margin:16px 12px;position:relative;display:block;"><?= __('Olá, ') ?><?= $this->request->Session()->read('user_name') ?></span>
            <?php 
          }//else if ($this->request->Session()->read('logomarca'))
        ?>
      </li>
      <?php 
      if ($this->request->Session()->read('locale') == 'pt_BR') {
          
          $locale = 'brz.png';
          $text_idioma = ' Mudar Idioma';
          
      } elseif ($this->request->Session()->read('locale') == 'en_US') {
          
          $locale = 'usa.png';
          $text_idioma = ' Change Idiom';
          
      } 
      ?>
      <!-- Control Sidebar Toggle Button -->
      <li class="dropdown notifications-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-gears"></i>
        </a>
        <ul class="dropdown-menu">
          <li>
            <ul class="control-sidebar-menu menu list-group" style="max-height:unset;">
              <li><?= $this->Html->link($this->Html->image($locale, ['width' => '15px']).$text_idioma, ['controller' => 'Pages', 'action' => 'changeLocale'], ['escape' => false]) ?></li>
              <li><?= $this->Html->link('<i class="fa fa-database"></i> '.__('Meus Dados'), ['controller' => 'Parameters', 'action' => 'index'], ['escape' => false]) ?></li>
              <?php 
              if ($this->request->Session()->read('sessionRule') != 'cont') { ?>
                <li><?= $this->Html->link(__('<i class="fa fa-user-plus"></i> '.'Usuários'), ['controller' => 'Users', 'action' => 'index'], ['escape' => false]) ?></li>
                <li><?= $this->Html->link(__('<i class="fa fa-usd"></i> '.'Pagamentos do Sistema'), ['controller' => 'Payments', 'action' => 'index'], ['escape' => false]) ?></li>
                <?php 
              } 
              if ($this->request->Session()->read('sessionRule') == 'super') { ?>
                <li><?= $this->Html->link(__('<i class="fa fa-repeat"></i> '.'Gerar Recorrentes'), ['controller' => 'Cron', 'action' => 'recurrent'], ['target' => '_blank', 'escape' => false]) ?></li>
                <li><?= $this->Html->link(__('<i class="fa fa-archive"></i> '.'Lista de Backups'), ['controller' => 'Backups', 'action' => 'index'], ['escape' => false]) ?></li>
                <li><?= $this->Html->link(__('<i class="fa fa-users"></i> '.'Vínculo de Usuários'), ['controller' => 'UsersParameters', 'action' => 'index'], ['escape' => false]) ?></li>
                <li><?= $this->Html->link(__('<i class="fa fa-plus-circle"></i> '.'Atualizar Saldos'), ['controller' => 'Balances', 'action' => 'superAddBalance'], ['class' => 'btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Atualizar Saldos', 'escape' => false]) ?></li>
                <li><?= $this->Html->link(__('<i class="fa fa-check"></i> '.'Conferir Bancos'), ['controller' => 'Balances', 'action' => 'checkBalanceBanks'], ['class' => 'btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Conferir Saldos de Bancos', 'escape' => false]) ?></li>
                <li><?= $this->Html->link(__('<i class="fa fa-check"></i> '.'Conferir Caixas'), ['controller' => 'Balances', 'action' => 'checkBalanceBoxes'], ['class' => 'btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Conferir Saldos de Caixas', 'escape' => false]) ?></li>
                <li><?= $this->Html->link(__('<i class="fa fa-usd"></i> '.'Saldos Financeiros'), ['controller' => 'Balances', 'action' => 'index'], ['target' => '_blank', 'escape' => false]) ?></li>
                <li><?= $this->Html->link(__('<i class="fa fa-cube"></i> '.'Saldos de Estoque'), ['controller' => 'StockBalances', 'action' => 'index'], ['target' => '_blank', 'escape' => false]) ?></li>
                <?php 
              } 
              if ($this->request->Session()->read('sessionRule') == 'admin' || $this->request->Session()->read('sessionRule') == 'super') { ?>
                <li><?= $this->Html->link(__('<i class="fa fa-file-text-o"></i> '.'Log de Registros'), ['controller' => 'Regs', 'action' => 'index'], ['escape' => false]) ?></li>
                <li><?= $this->Html->link(__('<i class="fa fa-file-text-o"></i> '.'System Logs'), ['controller' => 'Pages', 'action' => 'viewSystemLog'], ['class' => 'btn_modal', 'data-loading-text' => __('Loading...'), 'data-title' => __('System and Debug Logs'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link(__('<i class="fa fa-file-text-o"></i> '.'Update Logs'), ['controller' => 'Pages', 'action' => 'viewUpdateLog'], ['class' => 'btn_modal', 'data-loading-text' => __('Loading...'), 'data-title' => __('Update Logs'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link(__('<i class="fa fa-download"></i> '.'Backup do Sistema'), ['controller' => 'Backups', 'action' => 'backupFTP'], ['escape' => false]) ?></li>
                <li><?= $this->Html->link(__('<i class="fa fa-cloud-download"></i> '.'Atualizar Sistema'), ['controller' => 'Pages', 'action' => 'update?token=y5eehc123avse6463asd35k3cb6'], ['escape' => false]) ?></li>
                <?php 
              } ?>
              <li><?= $this->Html->link(__('<i class="fa fa-comments-o"></i> '.'Chamados de Suporte'), ['controller' => 'SupportContacts', 'action' => 'index'], ['escape' => false]) ?></li>
            </ul>
          </li>
        </ul>
      </li>

      <li><?= $this->Html->link('<i class="fa fa-sign-out"></i>', ['controller' => 'Pages', 'action' => 'logout'], ['title' => 'Sair', 'escape' => false]) ?></li>

      <!-- <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a></li> -->
    </ul>
  </div>
</nav>