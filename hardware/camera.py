from gpiozero import MotionSensor
from picamera import PiCamera
from datetime import datetime
from time import sleep
import subprocess

sensor = MotionSensor(14)
camera = PiCamera()

while True:
    sensor.wait_for_motion()
    filename = datetime.now().strftime("%H.%M.%S_%Y-%m-%d.jpg")
    camera.capture("/home/pi/Pictures/" + filename)
    sleep(5)
    cmd = "sudo bash transfer"
    p = subprocess.Popen(cmd, shell=True, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
    p.wait()