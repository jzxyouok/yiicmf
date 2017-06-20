<?php

/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 12.03.2016
 */

/**
 *
 * @return array
 */
function contentMenu()
{
    $result = [];
    
    if ($contentTypes = \yiisns\kernel\models\ContentType::find()->orderBy('priority ASC')->all()) {
        /**
         *
         * @var $contentType \yiisns\kernel\models\ContentType
         */
        foreach ($contentTypes as $contentType) {
            $itemData = [
                'code' => 'content-block-' . $contentType->id,
                'label' => $contentType->name,
                'img' => [
                    '\yiisns\admin\assets\AdminAsset',
                    'images/icons/icon.article.png'
                ]
            ];
            
            $contents = $contentType->getContents()
                ->andWhere([
                'visible' => 'Y'
            ])
                ->all();
            
            if ($contents) {
                foreach ($contents as $content) {
                    $itemData['items'][] = [
                        'label' => $content->name,
                        'url' => [
                            'admin/admin-content-element',
                            'content_id' => $content->id
                        ]
                    ];
                }
            }
            
            if (isset($itemData['items'])) {
                $result[] = new \yiisns\admin\helpers\AdminMenuItemConent($itemData);
            }
        }
    }
    return $result;
}

/**
 * Content Menu
 *
 * @return array
 */
function dashboardsMenu()
{
    $result = [];
    
    if ($dashboards = \yiisns\kernel\models\Dashboard::find()->orderBy('priority ASC')->all()) {
        /**
         *
         * @var $dashboard \yiisns\kernel\models\Dashboard
         */
        foreach ($dashboards as $dashboard) {
            $itemData = [
                'label' => \Yii::t('yiisns/kernel', $dashboard->name),
                'img' => [
                    '\yiisns\admin\assets\AdminAsset',
                    'images/icons/dashboard.png'
                ],
                'url' => [
                    'admin/index/dashboard',
                    'pk' => $dashboard->id
                ],
                'activeCallback' => function (\yiisns\admin\helpers\AdminMenuItem $adminMenuItem) {
                    return (bool) (\Yii::$app->controller->action->uniqueId == 'admin/index/dashboard' && \yii\helpers\ArrayHelper::getValue($adminMenuItem->url, 'pk') == \Yii::$app->request->get('pk'));
                }
            ];
            
            $result[] = $itemData;
        }
    } else {
        $result[] = [
            'label' => \Yii::t('yiisns/kernel', 'Create dashboard'),
            'url' => [
                'admin/index'
            ],
            'img' => [
                '\yiisns\admin\assets\AdminAsset',
                'images/icons/dashboard.png'
            ]
        ];
    }
    return $result;
}

/**
 *
 * @return array
 */
function contentEditMenu()
{
    $result = [];
    
    if ($contentTypes = \yiisns\kernel\models\ContentType::find()->orderBy('priority ASC')->all()) {
        /**
         *
         * @var $contentType \yiisns\kernel\models\ContentType
         */
        foreach ($contentTypes as $contentType) {
            $itemData = [
                'code' => 'content-block-edit-' . $contentType->id,
                'url' => [
                    '/admin/admin-content-type/update',
                    'pk' => $contentType->id
                ],
                'label' => $contentType->name,
                'img' => [
                    '\yiisns\admin\assets\AdminAsset',
                    'images/icons/icon.article.png'
                ],
                'activeCallback' => function (\yiisns\admin\helpers\AdminMenuItem $adminMenuItem) {
                    return (bool) (\Yii::$app->controller->action->uniqueId == 'admin/admin-content-type/update' && \yii\helpers\ArrayHelper::getValue($adminMenuItem->url, 'pk') == \Yii::$app->request->get('pk'));
                }
            ];
            
            if ($contents = $contentType->contents) {
                foreach ($contents as $content) {
                    $itemData['items'][] = [
                        'label' => $content->name,
                        'url' => [
                            'admin/admin-content/update',
                            'pk' => $content->id
                        ],
                        'activeCallback' => function (\yiisns\admin\helpers\AdminMenuItem $adminMenuItem) {
                            return (bool) (\Yii::$app->controller->action->uniqueId == 'admin/admin-content/update' && \yii\helpers\ArrayHelper::getValue($adminMenuItem->url, 'pk') == \Yii::$app->request->get('pk'));
                        }
                    ];
                }
            }
            
            $result[] = $itemData;
        }
    }
    return $result;
}

function componentsMenu()
{
    $result = [];
    
    if (\Yii::$app instanceof \yii\console\Application) {
        return $result;
    }
    
    foreach (\Yii::$app->getComponents(true) as $id => $data) {
        try {
            $loadedComponent = \Yii::$app->get($id);
            if ($loadedComponent instanceof \yiisns\kernel\base\Component) {
                $result[] = new \yiisns\admin\helpers\AdminMenuItem([
                    'label' => $loadedComponent->descriptor->name,
                    'url' => [
                        'admin/admin-settings',
                        'component' => $loadedComponent->className()
                    ],
                    'img' => $loadedComponent->img,
                    'activeCallback' => function (\yiisns\admin\helpers\AdminMenuItem $adminMenuItem) {
                        return (bool) (\Yii::$app->request->getUrl() == $adminMenuItem->getUrl());
                    }
                ]);
            }
        } catch (\Exception $e) {}
    }
    
    return $result;
}

return [
    'dashboard' => [
        'priority' => 90,
        'label' => \Yii::t('yiisns/kernel', 'My Dashboards'),
        'img' => [
            '\yiisns\admin\assets\AdminAsset',
            'images/icons/dashboard.png'
        ],
        
        'items' => dashboardsMenu()
    ],
    
    'content' => [
        'priority' => 200,
        'label' => \Yii::t('yiisns/kernel', 'Content management'),
        'img' => [
            '\yiisns\admin\assets\AdminAsset',
            'images/icons/sections.png'
        ],
        
        'items' => array_merge([
            [
                'label' => \Yii::t('yiisns/kernel', 'Section management'),
                'url' => [
                    'admin/admin-tree'
                ],
                'img' => [
                    '\yiisns\admin\assets\AdminAsset',
                    'images/icons/sections.png'
                ]
            ],
            
            [
                'label' => \Yii::t('yiisns/kernel', 'File management'),
                'url' => [
                    'admin/admin-file-manager'
                ],
                'img' => [
                    '\yiisns\admin\assets\AdminAsset',
                    'images/icons/folder.png'
                ]
            ],
            
            [
                'label' => \Yii::t('yiisns/kernel', 'File storage'),
                'url' => [
                    'admin/admin-storage-files'
                ],
                'img' => [
                    '\yiisns\admin\assets\AdminAsset',
                    'images/icons/storage_file.png'
                ]
            ]
        ], contentMenu())
    ],
    
    'users' => [
        'label' => \Yii::t('yiisns/kernel', 'User management'),
        'priority' => 100,
        'enabled' => true,
        'img' => [
            '\yiisns\admin\assets\AdminAsset',
            'images/icons/user.png'
        ],
        
        'items' => [
            [
                'label' => \Yii::t('yiisns/kernel', 'Users management'),
                'url' => [
                    'admin/admin-user'
                ],
                'img' => [
                    '\yiisns\admin\assets\AdminAsset',
                    'images/icons/user.png'
                ],
                'priority' => 100
            ],
            
            [
                'label' => \Yii::t('yiisns/kernel', 'User control properties'),
                'url' => [
                    'admin/admin-user-universal-property'
                ],
                'img' => [
                    '\yiisns\admin\assets\AdminAsset',
                    'images/icons/settings-big.png'
                ],
                'priority' => 900
            ],
            
            [
                'label' => \Yii::t('yiisns/kernel', 'User {attributes} extend', [
                    'attributes' => \Yii::t('yiisns/kernel', 'Email')
                ]),
                'url' => [
                    'admin/admin-user-email'
                ],
                'img' => [
                    '\yiisns\admin\assets\AdminAsset',
                    'images/icons/email-2.png'
                ],
                'priority' => 700
            ],
            
            [
                'label' => \Yii::t('yiisns/kernel', 'User {attributes} extend', [
                    'attributes' => \Yii::t('yiisns/kernel', 'Phone number')
                ]),
                'url' => [
                    'admin/admin-user-phone'
                ],
                'img' => [
                    '\yiisns\admin\assets\AdminAsset',
                    'images/icons/phone.png'
                ],
                'priority' => 800
            ]
        ]
    ],
    
    'settings' => [
        'priority' => 300,
        'label' => \Yii::t('yiisns/kernel', 'System settings'),
        'img' => [
            '\yiisns\admin\assets\AdminAsset',
            'images/icons/settings-big.png'
        ],
        
        'items' => [
            [
                'label' => \Yii::t('yiisns/kernel', 'Sites management'),
                'url' => [
                    'admin/admin-site'
                ],
                'img' => [
                    '\yiisns\admin\assets\AdminAsset',
                    'images/icons/www.png'
                ],
                'priority' => 100
            ],
            
            [
                'label' => \Yii::t('yiisns/kernel', 'Languages management'),
                'url' => [
                    'admin/admin-lang'
                ],
                'img' => [
                    '\yiisns\admin\assets\AdminAsset',
                    'images/icons/ru.png'
                ],
                'priority' => 200
            ],
            
            [
                'label' => \Yii::t('yiisns/kernel', 'Settings sections'),
                'url' => [
                    'admin/admin-tree-type'
                ],
                'img' => [
                    '\yiisns\admin\assets\AdminAsset',
                    'images/icons/icon.tree.gif'
                ],
                'priority' => 300
            ],
            
            [
                'label' => \Yii::t('yiisns/kernel', 'Content settings'),
                'url' => [
                    'admin/admin-content-type'
                ],
                'img' => [
                    '\yiisns\admin\assets\AdminAsset',
                    'images/icons/content.png'
                ],
                'priority' => 400,
                
                'items' => contentEditMenu()
            ],
            
            [
                'label' => \Yii::t('yiisns/kernel', 'Module settings'),
                'img' => [
                    '\yiisns\admin\assets\AdminAsset',
                    'images/icons/settings-big.png'
                ],
                'priority' => 500,
                'items' => componentsMenu()
            ],
            [
                'label' => \Yii::t('yiisns/kernel', 'Server file storage'),
                'url' => [
                    'admin/admin-storage/index'
                ],
                'img' => [
                    '\yiisns\admin\assets\AdminAsset',
                    'images/icons/servers.png'
                ],
                'priority' => 900
            ]
        ]
    ],
    
    'other' => [
        'priority' => 500,
        'label' => \Yii::t('yiisns/kernel', 'Additionally'),
        'img' => [
            '\yiisns\admin\assets\AdminAsset',
            'images/icons/other.png'
        ],
        
        'items' => [
            [
                'label' => \Yii::t('yiisns/kernel', 'System tools'),
                'priority' => 0,
                //'enabled' => true,
                
                'img' => [
                    '\yiisns\admin\assets\AdminAsset',
                    'images/icons/tools.png'
                ],
                
                'items' => [
                    
                    /*[
                        'label' => \Yii::t('yiisns/kernel', 'Checking system'),
                        'url' => [
                            'admin/checker'
                        ],
                        'img' => [
                            '\yiisns\admin\assets\AdminAsset',
                            'images/icons/tools.png'
                        ]
                    ],*/
                    
                    [
                        'label' => \Yii::t('yiisns/kernel', 'System information'),
                        'url' => [
                            'admin/info'
                        ],
                        'img' => [
                            '\yiisns\admin\assets\AdminAsset',
                            'images/icons/icon.infoblock.png'
                        ]
                    ],
                ]
            ],
            /**
             * TODO:: make a separate module
             *
             * [
             * 'label' => \Yii::t('yiisns/kernel', 'Code generator'). ' gii',
             * 'url' => ['admin/gii'],
             * 'img' => ['\yiisns\admin\assets\AdminAsset', 'images/icons/ssh.png'],
             * 'accessCallback'=> function()
             * {
             * if ((bool) \Yii::$app->hasModule('gii'))
             * {
             * /**
             *
             * @var $gii yii\gii\Module
             *      $gii = \Yii::$app->getModule('gii');
             *     
             *      $ip = \Yii::$app->getRequest()->getUserIP();
             *      foreach ($gii->allowedIPs as $filter) {
             *      if ($filter === '*' || $filter === $ip || (($pos = strpos($filter, '*')) !== false && !strncmp($ip, $filter, $pos))) {
             *      return true;
             *      }
             *      }
             *      }
             *     
             *      return false;
             *      },
             *      ],
             */
            [
                'label' => \Yii::t('yiisns/kernel', 'Clearing temporary data'),
                'url' => [
                    'admin/clear'
                ],
                'img' => [
                    '\yiisns\admin\assets\AdminAsset',
                    'images/icons/clear.png'
                ]
            ]
        ]
    ]
];