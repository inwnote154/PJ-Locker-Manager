# create_excel.py
import json
import openpyxl
import pyodbc
import pandas as pd
import os
server = "192.168.16.16"
database = "officecenter"
username = "sa"
password = "Eur@Admin"
driver = '{SQL Server Native Client 11.0}'
conn_str = f'DRIVER={driver};SERVER={server};DATABASE={database};UID={username};PWD={password}'
conn = pyodbc.connect(conn_str)
cursor = conn.cursor()
# อ่านข้อมูลจากไฟล์ JSON
query = "SELECT locker_employee.*, buddy_locker.*, building.*, Accesslog.*, department.* \
        FROM buddy_locker \
        LEFT JOIN Accesslog ON Accesslog.LockerNumber = buddy_locker.buddy_number \
        LEFT JOIN locker_employee ON Accesslog.EmployeeID = locker_employee.idcard \
        LEFT JOIN building ON buddy_locker.build_id = building.building_id \
        LEFT JOIN department ON locker_employee.departmentid = department.departmentno \
        WHERE Accesslog.StatusEm = 'active' AND Accesslog.TypeLocker = ? AND building_id = ? \
        ORDER BY buddy_number ASC"
df = pd.read_sql(query,conn)
excel_filename = 'output.xlsx'

# ตรวจสอบว่ามีไฟล์อยู่แล้วหรือไม่
if os.path.isfile(excel_filename):
    # หากมีไฟล์อยู่แล้ว สร้างชื่อไฟล์ใหม่โดยเพิ่มเลขลำดับ
    base_filename, file_extension = os.path.splitext(excel_filename)
    index = 1
    while os.path.isfile(f"{base_filename}_{index}{file_extension}"):
        index += 1
    excel_filename = f"{base_filename}_{index}{file_extension}"

# สร้าง DataFrame ด้วย pandas (เพียงเพื่อตัวอย่าง)

# บันทึกข้อมูลลงในไฟล์ Excel
df.to_excel(excel_filename, index=False)
