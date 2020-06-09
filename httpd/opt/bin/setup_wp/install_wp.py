import os
import sys
from pwd import getpwnam
import subprocess
import yaml
from pathlib import Path

args = sys.argv
wp_theme_name = args[1]
wp_dir = args[2]
wp_home_url = args[3]

print("install started.", flush=True)
with open("/opt/install/config.yml", "r") as f:
    wp_install_data = yaml.load(f, Loader=yaml.SafeLoader)

wp_dir_path = os.path.join('/var/www/html/', wp_dir)
theme_dir_path = os.path.join(wp_dir_path, "wp-content/themes/")
plugins_dir_path = os.path.join(wp_dir_path, "wp-content/plugins/")
upgrade_dir_path = os.path.join(wp_dir_path, "wp-content/upgrade/")
cli_yaml_path = os.path.join(wp_dir_path, "wp-cli.yml")

# wp-cliにわたすyaml作成
cli_yaml_data = {
    'path': wp_dir_path,
    'core install': {
        'admin_user': wp_install_data['admin_user'],
        'admin_email': wp_install_data['admin_email'],
        'title': wp_install_data['title'],
        'url': '{}/{}'.format(wp_home_url, wp_dir),
    }
}

os.makedirs(upgrade_dir_path, exist_ok=True)
www_user = getpwnam('www-data')
os.chown(theme_dir_path, www_user.pw_uid, www_user.pw_gid)
os.chown(plugins_dir_path, www_user.pw_uid, www_user.pw_gid)
os.chown(upgrade_dir_path, www_user.pw_uid, www_user.pw_gid)


with open(cli_yaml_path, "w") as f:
    f.write(yaml.dump(cli_yaml_data))

command1 = "sudo -u www-data /opt/bin/setup_wp/install_wp_core.sh {} {} {} {}".format(
    wp_install_data['admin_user'], wp_theme_name, wp_home_url, wp_dir)
command2 = "sudo -u www-data wp plugin install  {} --activate".format(
    ' '.join(wp_install_data['plugins']))

print("command: " + command1, flush=True)
proc = subprocess.run(command1, shell=True,
                      stdout=subprocess.PIPE, stderr=subprocess.PIPE)

install_result = proc.stdout.decode("utf8")
print(install_result, flush=True)
print(proc.stderr.decode("utf8"), flush=True)


for line in install_result.split('\n'):
  if line.find('Admin password:') != -1:
    print(line, flush=True)

# バックグラウンドでプラグインをインストール
# print("command: " + command2, flush=True)
proc = subprocess.Popen(command2, shell=True,
                        stdout=subprocess.PIPE, stderr=subprocess.PIPE)

os.remove(cli_yaml_path)
print("install finished.", flush=True)
