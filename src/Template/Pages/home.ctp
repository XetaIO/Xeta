<?= $this->element('meta') ?>

<?php $this->start('scriptBottom'); ?>
<?php echo $this->Html->script([
    'particles.min'
]); ?>
<script type="text/javascript">
    $('.counter').each(function() {
        $(this).appear(function() {
            var number = $(this).find('.counter-timer').attr('data-to');
            $(this).find('.counter-timer').countTo({from: 0, to: number, speed: 1500, refreshInterval: 30});
        });
    });

    particlesJS("particles", {
      "particles": {
        "number": {
          "value": 200,
          "density": {
            "enable": true,
            "value_area": 800
          }
        },
        "color" : {
          "value": "#fff"
        },
        "shape": {
          "type": "circle",
          "stroke": {
            "width": 0,
            "color": "#000000"
          },
          "polygon": {
            "nb_sides": 5
          }
        },
        "opacity": {
          "value": 0.5,
          "random": true,
          "anim": {
            "enable": false,
            "speed": 1,
            "opacity_min": 0.1,
            "sync": false
          }
        },
        "size": {
          "value": 7,
          "random": true,
          "anim": {
            "enable": true,
            "speed": 3,
            "size_min": 0.1,
            "sync": false
          }
        },
        "line_linked":{
          "enable": false,
          "distance": 500,
          "color": "#ffffff",
          "opacity": 0.4,
          "width": 2
        },
        "move":{
          "enable": true,
          "speed": 3,
          "direction": "bottom",
          "random": false,
          "straight": false,
          "out_mode": "out",
          "bounce": false,
          "attract": {
            "enable": false,
            "rotateX": 600,
            "rotateY":1200
          }
        }
      },
      "interactivity": {
        "detect_on": "canvas",
        "events": {
          "onhover": {
            "enable": true,
            "mode": "bubble"
          },
          "onclick": {
            "enable": true,
            "mode":"push"
          },
          "resize": true
        },
        "modes": {
          "grab": {
            "distance": 400,
            "line_linked": {
              "opacity":0.5
            }
          },
          "bubble": {
            "distance": 400,
            "size": 4,
            "duration": 0.3,
            "opacity": 1,
            "speed": 3
          },
          "repulse": {
            "distance": 200,
            "duration": 0.4
          },
          "push": {
            "particles_nb": 4
          },
          "remove": {
            "particles_nb": 2
          }
        }
      },
      "retina_detect":true
    });
</script>
<?php $this->end(); ?>

<?php $this->start('css'); ?>
    <?= $this->Html->css([
        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,400italic,700'
    ]); ?>
<?php $this->end(); ?>

<section id="home-particles">
    <div class="showcase">
      <div id="particles"></div>

      <div class="container" style="padding: 250px 0;">
        <div class="row">
          <div class="col-xs-12">
              <section class="hp-title animated bounceInDown">
                  <?= __("Welcome on {0} !", '<span>' . \Cake\Core\Configure::read('Site.name') . '</span>') ?>
              </section>
              <section class="hp-intro animated fadeIn">
                  <h3 class="hp-headline">
                      <?= __("Welcome to my personal website ! I use this site as my personal blog and for try my  experiences in development.") ?>
                  </h3>
              </section>
              <section>
                  <?php if (!$this->request->session()->read('Auth.User')) : ?>
                      <?= $this->Html->link(__("{0} Sign Up now", '<i class="fa fa-sign-in"></i>'), ['controller' => 'users', 'action' => 'login'], ['class' => 'btn btn-white-outline animated bounceInLeft', 'role' => 'button', 'escape' => false]) ?>
                      <?= $this->Html->link(__("{0} Visit the Blog", '<i class="fa fa-newspaper-o"></i>'), ['controller' => 'blog', 'action' => 'index'], ['class' => 'btn btn-white-outline animated bounceInLeft', 'role' => 'button', 'escape' => false]) ?>
                  <?php else : ?>
                      <?= $this->Html->link(__("{0} Visit the Blog", '<i class="fa fa-newspaper-o"></i>'), ['controller' => 'blog', 'action' => 'index'], ['class' => 'btn btn-white-outline animated bounceInUp', 'role' => 'button', 'escape' => false]) ?>
                  <?php endif; ?>
              </section>
          </div>
        </div>
      </div>
    </div>
</section>

<section id="features">
    <div class="container focus" id="change-navbar">
        <?= $this->Flash->render('badge') ?>
        <?= $this->Flash->render() ?>
        <div class="row">
            <div class="col-md-4">
                <div class="img-focus">
                    <span class="svg-icon flat-filled" id="filled-browser">
                        <svg class='flat_icon' xmlns='http://www.w3.org/2000/svg' width='100px' height='100px' viewBox='0 0 100 100' >
                            <path class='circle' d='M50,2.125c26.441,0,47.875,21.434,47.875,47.875S76.441,97.875,50,97.875C17.857,97.875,2.125,76.441,2.125,50S23.559,2.125,50,2.125z'/>
                            <g class='icon'>
                                <path class='base' d='M28.692,24.431h42.615c2.353,0,4.262,1.908,4.262,4.262v42.615c0,2.354-1.909,4.262-4.262,4.262H28.692c-2.354,0-4.262-1.908-4.262-4.262V28.692C24.431,26.338,26.339,24.431,28.692,24.431z'/>
                                <path class='screen' d='M27.982,38.637h44.036v32.672H27.982V38.637z'/>
                                <path class='top' d='M24.431,24.431h51.139v11.364H24.431V24.431z'/>
                                <path class='green' d='M47.159,27.271c1.57,0,2.841,1.273,2.841,2.841s-1.271,2.841-2.841,2.841c-1.569,0-2.841-1.272-2.841-2.841S45.589,27.271,47.159,27.271z'/>
                                <path class='orange' d='M38.344,27.271c1.569,0,2.841,1.273,2.841,2.841s-1.271,2.841-2.841,2.841s-2.841-1.272-2.841-2.841S36.776,27.271,38.344,27.271z'/>
                                <path class='red' fill='' d='M29.858,27.271c1.569,0,2.841,1.273,2.841,2.841s-1.272,2.841-2.841,2.841c-1.569,0-2.841-1.272-2.841-2.841S28.289,27.271,29.858,27.271z'/>
                            </g>
                        </svg>
                    </span>
                </div>
                <h2>
                    <?= __("Open Source") ?>
                </h2>
                <p>
                    <?= __("The code source of this website is open source and available on {0}. If you want to contribute, feel free to do a PR.", $this->Html->link('Github', \Cake\Core\Configure::read('Site.github_url'))) ?>
                </p>
            </div>
            <div class="col-md-4">
                <div class="img-focus">
                    <span class="svg-icon flat-filled" id="filled-winner">
                        <svg class='flat_icon' xmlns='http://www.w3.org/2000/svg' width='100px' height='100px' viewBox='0 0 100 100' >
                            <path class='circle' d='M50,2.125c26.441,0,47.875,21.434,47.875,47.875c0,26.441-21.434,47.875-47.875,47.875C17.857,97.875,2.125,76.441,2.125,50C2.125,23.559,23.559,2.125,50,2.125z'/>
                            <g class='icon'>
                                <path class='ribbon' d='M39.036,61.003h21.929l2.529,21.928L50,75.341l-13.494,7.59L39.036,61.003z'/>
                                <path class='base' d='M74.459,41.529c0,0.771-2.346,1.423-2.42,2.173c-0.074,0.765,2.102,1.855,1.955,2.599c-0.148,0.753-2.576,0.932-2.797,1.659c-0.223,0.734,1.697,2.231,1.406,2.933c-0.293,0.708-2.711,0.405-3.068,1.076c-0.361,0.675,1.227,2.518,0.805,3.15c-0.426,0.636-2.738-0.13-3.221,0.458c-0.484,0.59,0.715,2.708,0.176,3.247c-0.539,0.54-2.656-0.659-3.246-0.177c-0.59,0.484,0.176,2.795-0.457,3.221c-0.633,0.423-2.479-1.167-3.152-0.804c-0.67,0.357-0.369,2.773-1.076,3.066c-0.701,0.292-2.197-1.627-2.932-1.405c-0.727,0.221-0.906,2.649-1.66,2.798c-0.742,0.146-1.833-2.03-2.599-1.956c-0.753,0.074-1.401,2.42-2.173,2.42c-0.771,0-1.421-2.346-2.173-2.42c-0.765-0.074-1.856,2.103-2.599,1.956c-0.754-0.15-0.934-2.578-1.66-2.798c-0.733-0.222-2.23,1.697-2.932,1.405c-0.708-0.293-0.407-2.709-1.077-3.066c-0.675-0.363-2.519,1.227-3.151,0.804c-0.635-0.426,0.131-2.738-0.458-3.221c-0.589-0.482-2.707,0.717-3.247,0.177c-0.54-0.539,0.66-2.657,0.176-3.248c-0.484-0.589-2.795,0.178-3.22-0.457c-0.422-0.633,1.167-2.479,0.805-3.15c-0.359-0.671-2.775-0.369-3.068-1.076c-0.291-0.702,1.628-2.198,1.406-2.933c-0.22-0.725-2.648-0.906-2.797-1.659c-0.147-0.744,2.028-1.834,1.955-2.599c-0.074-0.752-2.42-1.402-2.42-2.173s2.346-1.423,2.42-2.173c0.074-0.765-2.101-1.857-1.955-2.599c0.149-0.754,2.578-0.933,2.797-1.659c0.223-0.734-1.697-2.231-1.406-2.933c0.293-0.708,2.709-0.406,3.069-1.076c0.361-0.675-1.228-2.519-0.805-3.151c0.425-0.634,2.736,0.132,3.219-0.457c0.485-0.587-0.715-2.709-0.175-3.248c0.54-0.54,2.657,0.66,3.247,0.176c0.589-0.483-0.177-2.795,0.457-3.22c0.633-0.423,2.478,1.167,3.151,0.805c0.67-0.358,0.369-2.775,1.077-3.069c0.701-0.29,2.198,1.63,2.933,1.407c0.724-0.221,0.905-2.649,1.659-2.797c0.743-0.146,1.834,2.028,2.599,1.955c0.752-0.074,1.402-2.42,2.173-2.42c0.771,0,1.422,2.346,2.173,2.42c0.766,0.074,1.856-2.101,2.599-1.954c0.756,0.149,0.934,2.577,1.66,2.794c0.732,0.225,2.23-1.695,2.934-1.404c0.705,0.293,0.404,2.71,1.074,3.068c0.676,0.363,2.52-1.227,3.152-0.804c0.635,0.425-0.133,2.736,0.457,3.219c0.588,0.483,2.709-0.716,3.246-0.175c0.539,0.54-0.66,2.657-0.176,3.247c0.484,0.589,2.795-0.177,3.221,0.457c0.422,0.633-1.166,2.478-0.805,3.151c0.357,0.67,2.775,0.369,3.068,1.076c0.291,0.702-1.629,2.198-1.406,2.933c0.221,0.724,2.648,0.905,2.797,1.659c0.146,0.742-2.029,1.834-1.955,2.599C72.113,40.108,74.459,40.758,74.459,41.529z'/>
                                <path class='text' d='M50.183,32.507h-2.711l-0.806,4.888h-2.357l0.806-4.888h-2.71l-0.806,4.888h-2.701l-0.417,2.731h2.668l-0.565,3.421h-2.706l-0.417,2.732h2.674L39.43,50.55h2.71l0.704-4.271h2.357l-0.704,4.271h2.71l0.704-4.271h2.831l0.418-2.732h-2.798l0.564-3.421h2.837l0.418-2.731h-2.805L50.183,32.507z M45.652,43.547H43.31l0.549-3.421h2.343L45.652,43.547z M57.184,32.521c-0.258,0.595-0.684,1.101-1.273,1.518c-0.588,0.417-1.209,0.664-1.859,0.74v1.898h2.313v13.873h2.719V32.521H57.184z'/>
                            </g>
                        </svg>
                    </span>
                </div>
                <h2>
                    <?= __("Experiences") ?>
                </h2>
                <p>
                    <?= __("I use this site for my personal experiences in development, to try new things like JS libraries, or PHP libraries.") ?>
                </p>
            </div>
            <div class="col-md-4">
                <div class="img-focus">
                    <span class="svg-icon flat-filled" id="filled-message">
                        <svg class='flat_icon' xmlns='http://www.w3.org/2000/svg' width='100px' height='100px' viewBox='0 0 100 100' >
                            <path class='circle' d='M50,2.125c26.441,0,47.875,21.434,47.875,47.875c0,26.441-21.434,47.875-47.875,47.875C17.857,97.875,2.125,76.441,2.125,50C2.125,23.559,23.559,2.125,50,2.125z'/>
                            <g class='icon'>
                                <path class='back' d='M75.139,28.854h-3.807l-8.125-8.125c-0.381-0.38-0.999-0.382-1.381,0l-8.124,8.125H36.428c-2.79,0-5.05,2.261-5.05,5.048v25.247c0,2.79,2.26,5.051,5.05,5.051h38.711c2.789,0,5.05-2.261,5.05-5.051V33.902C80.188,31.115,77.928,28.854,75.139,28.854z'/>
                                <path class='front' d='M63.571,35.8H24.862c-2.789,0-5.05,2.262-5.05,5.049v25.247c0,2.788,2.261,5.049,5.05,5.049h3.806l8.125,8.125c0.382,0.381,1,0.383,1.381,0l8.125-8.125h17.275c2.788,0,5.05-2.261,5.05-5.049V40.85C68.62,38.062,66.361,35.8,63.571,35.8z'/>
                                <path class='dots' d='M34.743,50.108c-1.858,0-3.365,1.507-3.365,3.366c0,1.86,1.506,3.367,3.365,3.367c1.86,0,3.367-1.507,3.367-3.367C38.109,51.615,36.603,50.108,34.743,50.108z M44.842,50.108c-1.858,0-3.367,1.507-3.367,3.366c0,1.86,1.507,3.367,3.367,3.367c1.859,0,3.366-1.507,3.366-3.367C48.208,51.615,46.701,50.108,44.842,50.108z M54.94,50.108c-1.857,0-3.365,1.507-3.365,3.366c0,1.86,1.506,3.367,3.365,3.367c1.86,0,3.366-1.507,3.366-3.367C58.307,51.615,56.8,50.108,54.94,50.108z'/>
                            </g>
                        </svg>
                    </span>
                </div>
                <h2>
                    <?= __("Interact") ?>
                </h2>
                <p>
                    <?= __("You can interact with {0}'s members in the blog or directly with me in the comments of an article.", \Cake\Core\Configure::read('Site.name')) ?>
                </p>
            </div>
          </div>
    </div>
</section>

<section>
    <div class="news">
        <div class="news-container">
            <h2>
                <?= __("Latest Articles") ?>
            </h2>
            <div class="articles">
                <div class="carousel">
                    <div class="container">
                        <div id="news-articles-slide" class="owl-carousel owl-theme">
                            <?php if ($articles->toArray()) : ?>
                                <?php foreach ($articles as $article) : ?>
                                    <div class="article">
                                        <h3>
                                            <?= $this->Html->link(
                                                $this->Text->truncate(
                                                    $article->title,
                                                    30,
                                                    [
                                                        'ellipsis' => '...',
                                                        'exact' => false
                                                    ]
                                                ),
                                                [
                                                    '_name' => 'blog-article',
                                                    'slug' => $article->title,
                                                    'id' => $article->id,
                                                    '?' => ['page' => $article->last_page]
                                                ]
                                            ) ?>
                                        </h3>
                                        <div class="content">
                                            <?= $this->Text->truncate(
                                                $article->content_empty,
                                                150,
                                                [
                                                    'ellipsis' => '...',
                                                    'exact' => false
                                                ]
                                            ) ?>
                                        </div>
                                        <p>
                                            <?= $this->Html->link(
                                                __("Read More {0}", '<i class="fa fa-arrow-right"></i>'),
                                                [
                                                    '_name' => 'blog-article',
                                                    'slug' => $article->title,
                                                    'id' => $article->id,
                                                    '?' => ['page' => $article->last_page]
                                                ],
                                                [
                                                    'class' => 'text-primary',
                                                    'escape' => false
                                                ]
                                            ) ?>
                                        </p>
                                        <div class="meta">
                                            <ul>
                                                <li>
                                                    <i class="fa fa-tag"></i>
                                                    <?= $this->Html->link(
                                                        h($article->blog_category->title),
                                                        [
                                                            '_name' => 'blog-category',
                                                            'slug' => $article->blog_category->title,
                                                            'id' => $article->blog_category->id
                                                        ]
                                                    ) ?>
                                                </li>
                                                <li>
                                                    <i class="fa fa-comment"></i>
                                                    <?= h($article->comment_count_format) ?>
                                                </li>
                                                <li>
                                                    <i class="fa fa-heart"></i>
                                                    <?= h($article->like_count_format) ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="customNavigation">
                        <a class="btn btn-default-outline prev"><i class="fa fa-chevron-left"></i></a>
                        <a class="btn btn-default-outline next"><i class="fa fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="counters" class="counters img-bg" style="background-image: url(<?= $this->Url->build('/img/home/features-background.jpg')?>);">
    <div class="counters-container">
        <div class="counters-arrow">
            <span class="right"></span>
            <span class="left"></span>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="counter">
                        <div class="counter-icon">
                            <span class="fa fa-users"></span>
                        </div>
                        <div class="counter-content">
                            <h2>
                                <span class="counter-timer" data-from="0" data-to="<?= h($statistics['Users']['TotalUsers']) ?>">
                                    <?= h($statistics['Users']['TotalUsers']) ?>
                                </span>
                            </h2>
                            <h6 class="counter-text"><?= __('Users') ?></h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="counter">
                        <div class="counter-icon">
                            <span class="fa fa-newspaper-o"></span>
                        </div>
                        <div class="counter-content">
                            <h2>
                                <span class="counter-timer" data-from="0" data-to="<?= h($statistics['Articles']) ?>">
                                    <?= h($statistics['Articles']) ?>
                                </span>
                            </h2>
                            <h6 class="counter-text"><?= __('Articles') ?></h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="counter">
                        <div class="counter-icon">
                            <span class="fa fa-comments-o"></span>
                        </div>
                        <div class="counter-content">
                            <h2>
                                <span class="counter-timer" data-from="0" data-to="<?= h($statistics['ArticlesComments']) ?>">
                                    <?= h($statistics['ArticlesComments']) ?>
                                </span>
                            </h2>
                            <h6 class="counter-text"><?= __('Comments') ?></h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="counter">
                        <div class="counter-icon">
                            <span class="fa fa-heart"></span>
                        </div>
                        <div class="counter-content">
                            <h2>
                                <span class="counter-timer" data-from="0" data-to="<?= h($statistics['ArticlesLikes']) ?>">
                                    <?= h($statistics['ArticlesLikes']) ?>
                                </span>
                            </h2>
                            <h6 class="counter-text"><?= __('Likes') ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12 news-comments">
                <h2>
                    <?= __("Latest Comments") ?>
                </h2>
                <div id="news-comments-slide" class="owl-carousel owl-theme">
                    <?php if ($comments->toArray()) : ?>
                        <?php foreach ($comments as $comment) : ?>
                            <div class="comments-box">
                                <div class="message">
                                    <?= $this->Text->truncate(
                                        $comment->content_empty,
                                        300,
                                        [
                                            'ellipsis' => '...',
                                            'exact' => false
                                        ]
                                    )?>
                                </div>
                                <div class="author">
                                    <div class="quote text-primary">
                                        <i class="fa fa-quote-left"></i>
                                    </div>
                                    <div class="info">
                                        <?= $this->Html->link($comment->user->full_name, ['_name' => 'users-profile',
                                                'slug' => $comment->user->username, 'id' => $comment->user->id], ['class' => 'name']) ?>
                                        <div class="article">
                                            <i class="fa fa-newspaper-o"></i>
                                            <?= $this->Html->link(
                                                $this->Text->truncate(
                                                    $comment->blog_article->title,
                                                    20,
                                                    [
                                                        'ellipsis' => '...',
                                                        'exact' => false
                                                    ]
                                                ),
                                                [
                                                    'controller' => 'blog',
                                                    'action' => 'go',
                                                    $comment->id
                                                ]
                                            ) ?>
                                        </div>
                                    </div>
                                    <div class="image visible-lg">
                                        <?= $this->Html->image($comment->user->avatar) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
body {
    margin-top: -1px;
}
.navbar-inverse {
    background: transparent !important;
    border-bottom: transparent;
    color: #fff;
}
</style>
