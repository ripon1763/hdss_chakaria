import pandas as pd, pyodbc, numpy as np, pyreadstat, sys
con_string = "driver={SQL SERVER}; server=172.29.29.37; database=urban_hdss_two_final; UID=sa; PWD=icddrb;"
cnxn = pyodbc.connect(con_string)
query = "SELECT* FROM "+sys.argv[1]
result_port_map = pd.read_sql(query, cnxn)
#x=result_port_map.columns.tolist()

#print(result_port_map)

df = result_port_map.fillna(value=np.nan)

df.to_excel(sys.argv[1]+'.xlsx')