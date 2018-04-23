<?php
$config = array (	
		// //应用ID,您的APPID。
		// 'app_id' => "2018031902405057",

		// //商户私钥，您的原始格式RSA私钥
		// 'merchant_private_key' => "MIIEpgIBAAKCAQEA0sOOXDloIndiY5VnlTlFRCDSyL6PIGTnnBuavPpTJRsbUBKs1PFynE7hQeb9WVof14gSq6yR7DuWj/ZvrVzHfA8Bhr8mOgOHe8pku5rLNCL+QeLxEuXmZH3e1Lk15pFT2O5cBCERXd3SbbIAL435rAFkLF9iQtYNw7FvKgfwNel+FhcCy2FptBVI1HGVuY7Z2OvQvDkmhrv/VJfSZcBMuuiJC9KFreLPJAeSgvqmb9342bFIbrUplpKrMtTd+z64lPVhfGHPu4GoJWxK2ZyjRnpY+nUZHre9cB+jsGTKE9T7uUoY6Fzc+N93b9vIMSBrjZ6jjScZMm22yoqpOcs3pQIDAQABAoIBAQCpvb8wfTdl0rpVs2Tp5GbpmHnKHNaOY1W4/u5fVkeSMcOMeI3jLdV9F3YJKmxOAux0G+3VfzVCiTcYGIQWngs22asEB3xU6rS5uOXpxZ/0DF6zV3+KFce4lTraHZPQbqiVpFpNJQikjVrE57+IjRJQOgqgRe2QIG6TdZouwpfuAfiKfOFnXZT5qxZgI/UV6b0Ti+d7D2T8rJib1NxY27C7+MK+lxgzJ1d82W8zn3JAUFGu7wC28ZN/u/sS+wKr3HbIuymMMf1RX6jiiApV8fX/W0jddUSBMrBykjXDpoP9oRzw1ggoHclYLzRCE/mGD88wmE7Y0VmZXlN+z4H5Hzy9AoGBAPgHS1YiQhQWM/DfnirrxKEh/prR/pBglUqpwT9KNvt6duz1rP4r+UgKW/JI+ooz5Xzs4FN4/8AshJBFfbghLW0rjQFgg3spn+wO+SmEhIvoaBIPfXr4pl7PPIJeXtNtls3YbDqGZKvx2SdAaON7BAnE1qNuhvpT1oopueCgq1DnAoGBANmJqNrtAF5xY4dE7QBGJ3KnbiJqzeDJ9IdausC67eiFuNns3Lp3tuNiekPM4HaQ7Kx9O73CdHDX5B4fpEmgtAbAPdyfSuU56I2KAv0Z63vmyJEm4GyU+iTDkqiKZ+asCdUv9GSn3wzv4G+FdPEvnMQvDj6EaVSSlnjBuW+FRsWTAoGBAJui2B9Ad/5qwEURzQpZz5Tc5Ar6YqbuNEAZrW2tgDrlaeLfdqI3rcEK3w91w+EdF5AAg/NdJf7M8JInSPBVwU+T2HNYwKh0Qim6a5cl1JaGS2ep2K9lf+BWYj3cQdyiE9MvTxqaYmmS5RTAUhEMjEglABqlrIVAPouMC1ts9pNZAoGBAJ5grQEG//fCkfXP5sUGTn4ZDAQewllgb5mEIudisQdTJCv1WRahRhPyhJWMOffYt5c1biNPybrGU5zi6Jd6Wtd3axKPHtYY/QjfbCGdl2aTtX6IUWh8ZkoR4Vq3ucGli1sdGM+XsLsYgcxv254lTfs/Tx2RBaa/OrIcSMe6vrXlAoGBANAvCUpe2zpMB7YfqLg9X1NQjsWj1fj5x7wG6HU91CXwWe2FeHVWq/sVtHntcegPhXpUY6n/ybGYccVJZltDhV4cmBJ1JDOLm731Lq7o64+43wIx9WwirZM72XlXs3lWPHqfo/m/z6VQF/YJqvmKyibDfNPxqDEWfUxtmS6SSo8Y",
		
		// //异步通知地址
		// 'notify_url' => "http://666.mmpkk.com/webpay/notify_url.php",
		
		// //同步跳转
		// 'return_url' => "http://666.mmpkk.com/index.php?m=index&c=test&a=zfbrecode",

		// //编码格式
		// 'charset' => "UTF-8",

		// //签名方式
		// 'sign_type'=>"RSA2",

		// //支付宝网关
		// 'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		// //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		// 'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAho9wh+xy2Fbdyi+/IZOeHjIaHrk8kSlqLehA328NpKVkf8hvhNrHg6xZadMTkYZ0Q00qr2Fm6jlKT+7ekawFJNz23V5kYW/hohmHCKTNDm7v4lygT+E9WkPxL1ng9DmS83w5/XBMtmjAc4Oo53h+RTqQquweFaB2SwlvrXQXaJ2TGxGZhrSYTdYDG4+KYi/hVC5w8V6jIFml+raZvrROShqQEU4Lj8NbxsyDRx7/C6jrT9AbzSCZnYVPTaRFmnEcoytuhuelv3WYm0UeezesDXSTAHxtsLC1Z2H0Hq+4mgPtVwY+Is5GMM37vWms3oGp9rQLnVIvTSHdScM4BUaCmwIDAQAB",
		
		//应用ID,您的APPID。
		'app_id' => "2018032902466725",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCR9z04ZLGGRUEmHwEYlJtDMd8X0GgnzlWvJH7Xh9XXR1rUkCml0dHsOipwIzvN50ky3fMZb3NbjmT6kNarVqC0/rDF1XyjMl0tAqzJDI4Dpg5djYdSBekI61JVr7hE2xFPMLDK51WBnIK5/bGJ2GYhVWgAYtSwp15xBPicZSRLFq8Xvcy81d/1wcx4QW1jVko2oWexrBA0N79QhK0PfET7pPc3WSeylEeiv1lY4B5bcbplTRFyUvuQdg8NHYeFq59j015+wvBU6Cdcvl1AJRMQbW/xk2viw363RstmG7DDrFZqlYXO6trnW2FQdZ0Rjh6csqXh0h1r4TeDIyQtAN8hAgMBAAECggEAVMU+s7qe8vjTfj0xWMItbZfQFbd+VefaEU5jr+5+fXk+Qga7eUbi4ItjTB7aQ5mYBEesQFBesYSAFpj5YyZ7TMJBjZOPwAOm41YTXOvCqlHNM/3W4gb2sKxh88uKe8qyQchoVF6HZS+tKDEy43hez+sW7Gp5VWLOUVruu31t14Eg0NNz7676J1sgV4a3B2mw4/avzlfxsz5yDjAFnGRUxPOKoUu3lGbGfVytqiCfNL/CJODIppDsCTQAU4VL5nTNDx8rzFexumZhHLvgVhc+bDJvSS827E0wlKPwQY2lVZvKRJGpOesxnZkOomg4ouvhvDkFR/9mII4GoN8mUqm9AQKBgQDhuYliAYGK23EehQCtAM9Josls70dR3iFKtyGjbh2jsGBBsrpo1nV4I1wvL2cUX1QabVtE2oanYaukrMTQdlUZqGjtSrNtrWF0j3nPNn119k5FWryvXb5XeXmgqoXaP1P7/xGuVGpwrLRjoonsQYC5oF4gUJC4XhPKniYxIBLV0QKBgQClixskXOqgg1H+PA/enhoQsE+mn4Af+9Yvo7X4mpxAxELZSBHlckUrftrZButP8J8Dt92xBUK8n7vzcxunOMQE2R+I5wmOrhArK5012k5jpSuUU0CMwSZ0aRR9mCV8opdgiBMDgNkidq842GPPkegrCkLuBBrVX1kVb7iSNc24UQKBgA2v+Hqu6LII2HUnT4EuGWO3sUsfv01hkNc8/5cvaDCy00NomREeYAUm78IUt8VuemUX2H72WU/xBj14FH8njcV+hs5Mx1CRQOWWhaZhAX6Tru9ZrzNbFd2sCgoKDQ/M40TWlLXjfIjUkCOyiXaAClQ3Oz3uZLgpTD3vFRXJghrhAoGAeVJPXAD0uxpC1w3xm3dHJv/v/+9ZGReZy2QxkrbM2PJ9A3y8EOoEI3JetTtK7VUtVK5FvNxcIpz2Q98SXyVNEziE0fJwoK6Uju7x0mvhk0mTfKre3ckYg6wXJkyA/Ky0QDy5opGlkIpmtERyMcd+3Twx/PnpKIMuaHVuUUk5MWECgYEAhl+cFSm3L4h9mBQoio8Em4x5YLllIp7qEZ73BDwzW/XtsbTKaKrDhZpkCUFnRxQH6F15Y3x6Y3gykzFGZlAB9bEfL48pvFW6lpcgI5Qdb8g1jExqRfq7spEoBkrrM3BZmoExD+5Gfx51RpsOrlBz2gd3ctxHVNoIaPfJ5igfnsE=",
		//异步通知地址
		'notify_url' => "http://666.mmpkk.com/webpay/notify_url.php",
		
		//同步跳转
		'return_url' => "http://666.mmpkk.com/index.php?m=index&c=test&a=zfbrecode",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzsvml7/tCO6kAATTHuDdZQrj4CfyyD9O9eoVKLDKNFLVWvqpa7h7pH55zzI5pyjRhv3PG78bnd/Ubwno8rsaNyLZwfBElrjWpp2ZSsp5ogR0DR6uymPYoPDoQu3pVtp5jobjchmiXj5SCYlknKnBa/NeXVG41KZ/92Plb7Ez2Jl0JqoicrIagQnEJpC8fSTxc7bnevs9cbsYiRY6lv6w1UYHZyumpQ/rCwTa6LGLG1ScAHP3WZGrUSOyBPweUoxYX5dIFkH0gCl4rzIbAqmvDZDSvsuLlpNgT9hJq+quZZ98rRgI+gipKpvURib25tOn41XTO8kLOAGKYJhESCOR3QIDAQAB",
);