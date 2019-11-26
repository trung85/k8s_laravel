
### Install Laravel with [composer](https://getcomposer.org/)

```bash
composer global require "laravel/installer"
```

### Create new Laravel project

```bash
composer create-project --prefer-dist laravel/laravel laravel-project
```

If you installed [docker-compose](https://docs.docker.com/compose/install/) already, simply run:

```bash
docker-compose up
```

Composer will remain running if you need to install additional vendor libraries, simply enter composer container shell with and for example install [Redis](https://laravel.com/docs/5.7/redis) support libs:

```bash
docker exec -ti composer bash
composer require predis/predis
composer require laravel/horizon
```

### start horizon
```bash
php artisan horizon

php artisan horizon:pause
php artisan horizon:continue

php artisan horizon:terminate
```

Node container:

```bash
docker exec -ti node bash
npm install
```

# Docker

For the purpose of this demo I've built a public Docker image and pushed to my account. `Dockerfile` adds Laravel app into a lightweight alpine image.

## build application docker image

```
docker build -t minhtrung/k8s-laravel .
```

## push image to the repository

```
docker push minhtrung/k8s-laravel
```

# Kubernetes

[Google Cloud](https://cloud.google.com/)
[AWS services](https://aws.amazon.com/)

[KOPS](https://github.com/kubernetes/kops)
[AWS EKS](https://aws.amazon.com/eks/)
[GKE](https://cloud.google.com/kubernetes-engine/)

[Helm](https://helm.sh/)

### test dry run helm chart

```bash
helm install laravel-labs --dry-run --debug ./laravel
```

### install or upgrade current helm chart

```bash
helm install laravel-labs ./laravel
```

```bash
helm upgrade laravel-labs ./laravel -i
```

### delete helm chart

```bash
helm del --purge laravel-labs
```

# Install Application

### delete helm chart
```bash
helm list -a
helm del --purge laravel-labs
```

### install helm chart
```bash
helm install --name laravel-labs ./laravel
```

### get pods list
```bash
kubectl get pods -o wide
```

### upgrade app
```bash
helm upgrade laravel-labs --set image.tag='release-2019-11-14-095326' ./laravel


```

### forward port
```bash
kubectl port-forward laravel-labs-k8s-laravel-578c7785b-ghspg 9001:80
Forwarding from 127.0.0.1:9001 -> 80
Forwarding from [::1]:9001 -> 80
```

### migrate database
link: https://laravel.com/docs/5.8/horizon

```bash
php artisan migrate
php artisan db:seed
```

## Ingress / Load Balancing

Every time you deploy a completely independent application on Kubernetes exposed to the public network - it will probably come with a Load Balancer service. This may be costly if you have to deploy several of them.

Instead better solution is to use [Nginx Ingress Helm Chart](https://github.com/helm/charts/tree/master/stable/nginx-ingress) with a single Load Balancer and IP address. You can deploy as many new services as you need and use [Ingress](https://kubernetes.io/docs/concepts/services-networking/ingress/) to route the traffic to a specific app.

## SSL support

The easiest way to deploy SSL protected application is to use [Cert Manager](https://github.com/helm/charts/tree/master/stable/cert-manager) Helm Chart, which will provision SSL certificates using free [Let's Encrypt](https://letsencrypt.org/) service.

Deploying SSL protected sites is as simple as adding a single line in your ingress.yaml
